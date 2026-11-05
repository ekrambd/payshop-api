<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Variant;
use DB;
use App\Models\DeliveryChargeSetting;

class VendorOrderController extends Controller
{   

	public function __construct()
    {
        $this->middleware('auth_check');
    }

    public function myOrders(Request $request)
    {
    	// $data = Order::with('user')->join('order_details','orders.id','order_details.order_id')
    	//                ->join('users','order_details.user_id','users.id')
    	//                ->join('products','order_details.product_id','products.id')
    	//                ->leftJoin('variants','order_details.variant_id','variants.id')
    	//                ->leftJoin('product_variants','order_details.product_variant_id','product_variants.id')
    	//                ->select('orders.*','order_details.id as order_detail_id','order_details.purchase_price','order_details.purchase_discount','order_details.qty as purchase_qty','variants.id as variant_id','variants.variant_name','product_variants.variant_value','orders.date as order_date','orders.time as order_time')
    	//                ->where('order_details.user_id',3)
    	//                ->orderBy('orders.id','DESC')
    	//                ->get();
        
        


	    if ($request->ajax()) {

            $data = Order::with([
			        'user',
			        'orderDetails.product',
			        'orderDetails.variant',
			        'orderDetails.productVariant'
			    ])
			    ->whereHas('orderDetails', function ($q) {
			        $q->where('user_id', user()->id);
			    })
			    ->orderByDesc('id')
			    ->get();

            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('status', function ($row) {

                    //$viewURL = route('users.show', $row->id);

                    return $row->status;
                })


                ->addColumn('action', function ($row) {

                    //$viewURL = route('users.show', $row->id);

                    $viewURL = url('/vendor-order-details/'.$row->id);
                    
                    $invoiceURL = url('/invoice/'.$row->id);

                    return '
                        <a href="' . $viewURL . '" class="btn btn-primary btn-sm action-button show-order" data-id="' . $row->id . '">
                            <i class="fa fa-eye"></i>
                        </a>

                        &nbsp

                        <a href="' . $invoiceURL . '" class="btn btn-info btn-sm action-button show-order" data-id="' . $row->id . '">
                            <i class="fa fa-list"></i>
                        </a>

                        &nbsp

                        <a href="#" class="btn btn-danger btn-sm delete-order action-button" data-id="' . $row->id . '">
                            <i class="fa fa-trash"></i>
                        </a>
                    ';
                })

                ->rawColumns(['action','status'])
                ->make(true);
        }

        return view('vendors.orders');


    }
    
    public function invoice($id)
    {
        $order = Order::with('user')->findOrFail($id);
	    $deliveryCharge = DeliveryChargeSetting::where('user_id', user()->id)->first();
	    $products = Product::with('unit')->join('order_details', 'products.id', '=', 'order_details.product_id')
	        ->select(
	            'order_details.id',
	            'order_details.order_id',
	            'order_details.purchase_price',
	            'order_details.purchase_discount',
	            'order_details.qty',
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
	        ->where('order_details.order_id', $id)
	        ->groupBy('products.id')
	        ->get()
	        ->transform(function ($product) {

	            $product->variants = Variant::whereHas('productVariants', function ($q) use ($product) {

	                $q->whereIn('id', function ($query) use ($product) {

	                    $query->select('product_variant_id')
	                        ->from('order_details')
	                        ->where('order_id', $product->order_id)
	                        ->where('product_id', $product->product_id);

	                });

	            })
	            ->with([
	                'productVariants' => function ($q) use ($product) {

	                    $q->whereIn('id', function ($query) use ($product) {

	                        $query->select('product_variant_id')
	                            ->from('order_details')
	                            ->where('order_id', $product->order_id)
	                            ->where('product_id', $product->product_id);

	                    });

	                }
	            ])
	            ->get();

	            return $product;

	        });

	        $grandTotal = $products->sum(function ($product) {

	        return ($product->purchase_price - $product->purchase_discount) * $product->qty;

	    });

	    return view('vendors.invoice', compact(
	        'order',
	        'products',
	        'grandTotal',
	        'deliveryCharge'
	    ));
    }

    public function orderStatusChange(Request $request)
    {
    	try
    	{
    		$order = OrderDetail::findorfail($request->order_id);
    		$order->status = $request->status;
    		$order->update();
    		return response()->json(['status'=>true, 'message'=>"Successfully {$order->status}"]);
    	}catch(\Exception $e){
    		return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
    	}
    }

    public function editOrderStatus(Request $request)
    {
    	try
    	{
    		DB::table('order_details')->where('order_id',$request->order_id)->where('user_id',user()->id)->update(['status'=>$request->status]);
    		return response()->json(['status'=>true, 'message'=>'Successfully Updated']);
    	}catch(\Exception $e){
    		return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
    	}
    }

    public function vendorOrderDetails($id)
	{
	    $order = Order::with('user')->findOrFail($id);
	    // return $order;
	    $deliveryCharge = $order->delivery_charge;
	    //return $deliveryCharge;
	    $products = Product::with('unit')->join('order_details', 'products.id', '=', 'order_details.product_id')
	        ->select(
	            'order_details.id',
	            'order_details.order_id',
	            'order_details.purchase_price',
	            'order_details.purchase_discount',
	            'order_details.qty',
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
	        ->where('order_details.order_id', $id)
	        ->where('products.user_id',user()->id)
	        ->groupBy('products.id')
	        ->get()
	        ->transform(function ($product) {

	            $product->variants = Variant::whereHas('productVariants', function ($q) use ($product) {

	                $q->whereIn('id', function ($query) use ($product) {

	                    $query->select('product_variant_id')
	                        ->from('order_details')
	                        ->where('order_id', $product->order_id)
	                        ->where('product_id', $product->product_id);

	                });

	            })
	            ->with([
	                'productVariants' => function ($q) use ($product) {

	                    $q->whereIn('id', function ($query) use ($product) {

	                        $query->select('product_variant_id')
	                            ->from('order_details')
	                            ->where('order_id', $product->order_id)
	                            ->where('product_id', $product->product_id);

	                    });

	                }
	            ])
	            ->get();

	            return $product;

	        });

	        $grandTotal = $products->sum(function ($product) {

	        return ($product->purchase_price - $product->purchase_discount) * $product->qty;

	    });

	    return view('vendors.order_details', compact(
	        'order',
	        'products',
	        'grandTotal',
	        'deliveryCharge'
	    ));
	} 

	public function editOrderPlaceType(Request $request)
	{
		try
		{
			DB::table('order_details')->where('order_id',$request->order_id)->where('user_id',user()->id)->update(['place_type'=>$request->place_type]);
			$order = Order::where('id',$request->order_id)->update(['sub_total'=>$request->order_total,'total'=>$request->order_total]);
    		return response()->json(['status'=>true, 'message'=>'Successfully Updated']);
		}catch(\Exception $e){
    		return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
    	}
	}
}
