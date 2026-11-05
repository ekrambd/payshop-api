<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Category;
use Session;
use App\Models\Cart;
use App\Models\ProductVariant;
//use App\Models\Variant;
use App\Models\Subcategory;

class DetailController extends Controller
{
    public function productDetails($slug)
    {   

    	$categories = Category::where('status','Active')->latest()->take(10)->get();
    	$product = Product::with('category','unit','productVariants.variant')->where('slug',$slug)->first();
    	$relatedProducts = Product::where('category_id',$product->category_id)->where('id','!=',$product->id)->take(12)->get();

    	$cartCount = Cart::where('cart_session_id',Session::get('cart_session_id'))->count();

    	$productVariants = $product->productVariants()->get();

    	$productImageVariants = $product->productVariants()
					    ->whereNotNull('image')
					    ->get();

		$variants = Variant::whereHas('productVariants')->with(['productVariants' => function ($q) use ($product) {
	        $q->where('product_id', $product->id);
	    }])->get();
		//return $variants;

    	//return $productVariants;

    	$getCurrency = Session::get('currency');
		if($getCurrency == 'usd_rate'){
			$currency = '$';
		}elseif($getCurrency == 'jpn_rate'){
			$currency = '¥';
		}elseif($getCurrency == 'ksa_riyal'){
			$currency = 'SAR';
		}else{
			$currency = '৳';
		}
    	return view('product_details', compact('product','relatedProducts','currency','categories','cartCount','productVariants','productImageVariants','variants'));
    }

    public function shop(Request $request)
    {   
    	$categories = Category::whereHas('products')->where('status','Active')->latest()->take(12)->get();
    	//$products = Product::with('user','category')->where('status','Active')->latest()->paginate(9);
    	$query = Product::query();
    	if($request->has('value')){
    		if($request->value == 'hit_count'){
    			$query->orderBy('hit_count','DESC');
    		}else if($request->value == 'latest'){
    			$query->latest();
    		}else if($request->value == 'low_to_high'){
    			$query->orderBy('product_price','ASC');
    		}else if($request->value == 'high_to_low'){
    			$query->orderBy('product_price','DESC');
    		}
    	}

    	$products = $query->with('user','category')->where('status','Active')->latest()->paginate(9);



    	return view('shop',compact('categories','products'));
    }

    public function categoryDetails(Request $request,$slug)
    {   

    	$category = Category::where('slug',$slug)->first();

    	$categories = Category::whereHas('products')->where('id','!=',$category->id)->where('status','Active')->latest()->take(12)->get();
    	//$products = Product::with('user','category')->where('status','Active')->latest()->paginate(9);
    	$query = Product::query();
    	if($request->has('value')){
    		if($request->value == 'hit_count'){
    			$query->orderBy('hit_count','DESC');
    		}else if($request->value == 'latest'){
    			$query->latest();
    		}else if($request->value == 'low_to_high'){
    			$query->orderBy('product_price','ASC');
    		}else if($request->value == 'high_to_low'){
    			$query->orderBy('product_price','DESC');
    		}
    	}

    	$products = $query->with('user','category')->where('category_id',$category->id)->where('status','Active')->latest()->paginate(9);



    	return view('category_details',compact('categories','products','category'));
    }

    public function subcategoryDetails(Request $request, $id)
    {
        $subcategory = Subcategory::findorfail($id);



        $categories = Category::whereHas('products')->where('status','Active')->latest()->take(12)->get();
        //$products = Product::with('user','category')->where('status','Active')->latest()->paginate(9);
        $query = Product::query();
        if($request->has('value')){
            if($request->value == 'hit_count'){
                $query->orderBy('hit_count','DESC');
            }else if($request->value == 'latest'){
                $query->latest();
            }else if($request->value == 'low_to_high'){
                $query->orderBy('product_price','ASC');
            }else if($request->value == 'high_to_low'){
                $query->orderBy('product_price','DESC');
            }
        }

        $products = $query->with('user','category')->where('subcategory_id',$subcategory->id)->where('status','Active')->latest()->paginate(9);

        //return $products;


        return view('subcategory_details',compact('categories','products','subcategory')); 
    }

    public function searchProduct(Request $request)
    {
        $search = $request->search;
        $query = Product::query();
        if($request->has('category_id') && !empty($request->category_id))
        {
            $query->where('category_id',$request->category_id);
        }

        $categories = Category::whereHas('products')->where('status','Active')->latest()->take(12)->get();

        $products = $query->where('product_name', 'LIKE', "%{$search}%")->latest()->paginate(10);
        return view('search_product', compact('products','search','categories'));
    }
}
