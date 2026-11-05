<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Variant;
use App\Models\ProductVariant;
use Session;
// session_start();
use App\Models\Whishlist;

class CartController extends Controller
{
	public function addToCart(Request $request)
	{
	    try
	    {
	        $cartSessionID = Session::get('cart_session_id');

	        if (empty($cartSessionID)) {

	            $cartCount = Cart::count() + 1;

	            $sessionID = rand(1000, 9999) . $cartCount;

	            Session::put('cart_session_id', $sessionID);

	            $cartSessionID = $sessionID;
	        }

	        $product = Product::findOrFail($request->product_id);

	        $price = $product->product_discount > 0
	            ? $product->discount_price
	            : $product->original_price;

	        $cart = Cart::where('cart_session_id', $cartSessionID)
	            ->where('product_id', $request->product_id)
	            ->first();

	        if (!$cart) {

	            $cart = new Cart();

	            $cart->cart_session_id = $cartSessionID;
	            $cart->product_id = $request->product_id;
	            $cart->cart_qty = 1;
	            $cart->cart_price = $price;
	            $cart->vendor_id = $product->user->vendor->id;
	            $cart->currency = Session::get('currency', 'USD');
	            $cart->unit_total = $price;

	            $cart->save();

	        } else {

	            $qty = $cart->cart_qty + 1;

	            $cart->cart_qty = $qty;
	            $cart->unit_total = $cart->cart_price * $qty;
	            $cart->currency = Session::get('currency', 'USD');

	            $cart->save();
	        }

	        $cartCount = Cart::where('cart_session_id', $cartSessionID)->count();

	        return response()->json([
	            'status' => true,
	            'cart_count' => $cartCount,
	            'message' => 'Successfully the product has been added to cart'
	        ]);

	    } catch (\Exception $e) {

	        return response()->json([
	            'status' => false,
	            'code' => $e->getCode(),
	            'message' => $e->getMessage()
	        ], 500);
	    }
	}

	public function cartDetails()
	{   
		// $products = Product::join('carts','products.id','carts.product_id')
		//                     ->select('carts.id', 'carts.cart_session_id','carts.cart_price','carts.cart_qty','cart_unit_total','carts.product_id as product_ud','carts.variant_id','carts.product_variant_id','products.id as product_id', 'products.category_id','products.subcategory_id','products.unit_id','products.product_name','products.slug','products.product_price','products.product_discount','products.stock_qty','products.description','products.featured_image')
		//                     ->where('cart_session_id',Session::get('cart_session_id'))
		//                     ->get();


		$products = Product::join('carts', 'products.id', '=', 'carts.product_id')
		    ->select(
		        'carts.id',
		        'carts.cart_session_id',
		        'carts.cart_price',
		        'carts.cart_qty',
		        'carts.unit_total',
		        'carts.product_id as cart_product_id',
		        'carts.variant_id',
		        'carts.product_variant_id',
		        'products.id as product_id',
		        'products.category_id',
		        'products.subcategory_id',
		        'products.unit_id',
		        'products.product_name',
		        'products.slug',
		        'products.product_price',
		        'products.product_discount',
		        'products.stock_qty',
		        'products.description',
		        'products.featured_image'
		    )
		    ->where('carts.cart_session_id', Session::get('cart_session_id'))
		    ->groupBy('products.id')
		    ->get()
		    ->transform(function ($product) {

		        $product->variants = Variant::whereHas('productVariants', function ($q) use ($product) {

		            $q->whereIn('id', function ($query) use ($product) {

		                $query->select('product_variant_id')
		                    ->from('carts')
		                    ->where('cart_session_id', $product->cart_session_id)
		                    ->where('product_id', $product->product_id);

		            });

		        })
		        ->with([
		            'productVariants' => function ($q) use ($product) {

		                $q->whereIn('id', function ($query) use ($product) {

		                    $query->select('product_variant_id')
		                        ->from('carts')
		                        ->where('cart_session_id', $product->cart_session_id)
		                        ->where('product_id', $product->product_id);

		                });

		            }
		        ])
		        ->get();

		        return $product;

		    });

		//return $products;

		$sum = Cart::selectRaw('MAX(unit_total) as total')
		    ->where('cart_session_id', Session::get('cart_session_id'))
		    ->groupBy('product_id')
		    ->pluck('total')
		    ->sum();

		$carts = Cart::with('product','variant','productVariant')->where('cart_session_id',Session::get('cart_session_id'))->get();
		// $variants = Variant::whereHas('productVariants')->with('productVariants')->get();
		// return $variants;

		//$products = Product::with('category')->where('id',)

		// $sum = Cart::where('cart_session_id',Session::get('cart_session_id'))->groupBy('product_id')->sum('unit_total');

		$sum = Cart::selectRaw('product_id, MAX(unit_total) as total')
			    ->where('cart_session_id', Session::get('cart_session_id'))
			    ->groupBy('product_id')
			    ->get()
			    ->sum('total');


		return view('layouts.front_app_two', compact('carts','sum','products'));
	}

	public function updateCart(Request $request)
	{
	    foreach ($request->cart_ids as $cartId) {

	        $cart = Cart::find($cartId);

	        if ($cart) {

	            $qty = $request->cart_qty[$cartId];

	            $cart->cart_qty = $qty;
	            $cart->unit_total = $cart->cart_price * $qty;

	            $cart->save();
	        }
	    }

	    return redirect()
	        ->back()
	        ->with('success', 'Cart updated successfully');
	}

	public function deleteCart($id)
	{
		try
		{
			$cart = Cart::findorfail($id);
			$cart->delete();
			return response()->json(['status'=>true, 'message'=>'Successfully the cart has been deleted']);
		}catch(\Exception $e){
			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
		}
	}

	public function variantDetails($id)
	{
		try
		{
			$variant = ProductVariant::findorfail($id);
			return response()->json(['status'=>true, 'data'=>$variant]);
		}catch(\Exception $e){
			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
		}
	}

	public function addToWishList(Request $request)
	{
		try
		{
			if(auth()->check()){
				$count = Whishlist::where('user_id',user()->id)->where('product_id',$request->product_id)->count();
				if($count > 0){
					return response()->json(['status'=>false, 'message'=>'The product has already been taken in wishlist']);
				}

				$wishlist = new Whishlist();
				$wishlist->user_id = user()->id;
				$wishlist->product_id = $request->product_id;
				$wishlist->save();

				return response()->json(['status'=>true, 'message'=>'Successfully the product has been added to wishlist']);
			}

			return response()->json(['status'=>false, 'message'=>'Please Logged In First']);

		}catch(\Exception $e){
			return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
		}
	}

	public function saveSingleCart(Request $request)
	{
	    try {

	        $product = Product::findOrFail($request->cart_product_id);

	        $qty = $request->cart_qty ?? 1;

	        $price = $product->product_discount > 0
	            ? $product->discount_price
	            : $product->original_price;

	        $cartSessionID = Session::get('cart_session_id');

	        if (empty($cartSessionID)) {

	            $cartCount = Cart::count() + 1;

	            $cartSessionID = rand(1000, 9999) . $cartCount;

	            Session::put('cart_session_id', $cartSessionID);
	        }

	        /*
	        |--------------------------------------------------------------------------
	        | Product With Variants
	        |--------------------------------------------------------------------------
	        */

	        if (!empty($request->variant_ids)) {

	            $variantIds = array_filter(explode(',', $request->variant_ids));

	            foreach ($variantIds as $productVariantId) {

	                $exists = Cart::where('cart_session_id', $cartSessionID)
	                    ->where('product_variant_id', $productVariantId)
	                    ->first();

	                if ($exists) {

	                    $exists->cart_qty += $qty;
	                    $exists->unit_total = $exists->cart_qty * $exists->cart_price;
	                    $exists->save();

	                    continue;
	                }

	                $productVariant = ProductVariant::findOrFail($productVariantId);

	                Cart::create([

	                    'cart_session_id'  => $cartSessionID,
	                    'product_id'       => $product->id,
	                    'variant_id'       => $productVariant->variant_id,
	                    'product_variant_id' => $productVariant->id,
	                    'cart_price'       => $price,
	                    'cart_qty'         => $qty,
	                    'currency'         => Session::get('currency', 'USD'),
	                    'vendor_id'        => $product->user->vendor->id,
	                    'unit_total'       => $price * $qty,

	                ]);

	            }

	            $cartCount = Cart::where('cart_session_id', $cartSessionID)->count();

	            // return response()->json([
	            //     'status' => true,
	            //     'cart_count' => $cartCount,
	            //     'message' => 'Product added to cart successfully.'
	            // ]);

	            return redirect('/cart-details');
	        }

	        /*
	        |--------------------------------------------------------------------------
	        | Product Without Variant
	        |--------------------------------------------------------------------------
	        */

	        $cart = Cart::where('cart_session_id', $cartSessionID)
	            ->where('product_id', $product->id)
	            ->whereNull('product_variant_id')
	            ->first();

	        if ($cart) {

	            $cart->cart_qty += $qty;
	            $cart->unit_total = $cart->cart_qty * $cart->cart_price;
	            $cart->save();

	        } else {

	            Cart::create([

	                'cart_session_id' => $cartSessionID,
	                'product_id'      => $product->id,
	                'cart_price'      => $price,
	                'cart_qty'        => $qty,
	                'currency'        => Session::get('currency', 'USD'),
	                'vendor_id'       => $product->user->vendor->id,
	                'unit_total'      => $price * $qty,

	            ]);

	        }

	        $cartCount = Cart::where('cart_session_id', $cartSessionID)->count();

	        // return response()->json([
	        //     'status' => true,
	        //     'cart_count' => $cartCount,
	        //     'message' => 'Product added to cart successfully.'
	        // ]);

	        return redirect('/cart-details');

	    } catch (\Exception $e) {

	        return response()->json([
	            'status' => false,
	            'code' => $e->getCode(),
	            'message' => $e->getMessage()
	        ], 500);

	    }
	}

}
