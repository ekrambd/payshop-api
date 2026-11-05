<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Productdeliverycharge;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\DeliveryChargeRequest;
use Image;
use DataTables;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(
        protected ProductService $productService
    ) {
        $this->middleware('auth_check');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $products = $this->productService->fetch()->where('user_id',auth()->id())->latest();

            return datatables()->of($products)
                ->addIndexColumn()

                ->addColumn('image', function ($row) {
                    return '<img src="'.asset($row->featured_image).'" width="60">';
                })

                ->addColumn('category', function ($row) {
                    return $row->category->category_name;
                })

                ->addColumn('unit', function ($row) {
                    return $row->unit->unit_name;
                })

                // ->addColumn('status', function ($row) {

                //     $checked = $row->status == 'Active' ? 'checked' : '';

                //     return '
                //         <label class="switch">
                //             <input type="checkbox"
                //                 id="status-product-update"
                //                 data-id="'.$row->id.'"
                //                 '.$checked.'>
                //             <span class="slider round"></span>
                //         </label>
                //     ';
                // })

                ->addColumn('action', function ($row) {
                    $variantUrl = url('/add-product-variant/'.$row->id);
                    $deliveryChargeUrl = url('/add-delivery-charge/'.$row->id);
                    return '
               
                        <a href="' . $variantUrl . '"
                           class="btn btn-success btn-sm action-button add-product-variant my-2" >
                            Add/Edit Variant
                        </a>

                      

                        <a href="'.$deliveryChargeUrl.'" class="btn btn-info btn-sm my-2">Add Delivery Charge</a>
                        

                        <a href="'.route('products.show',$row->id).'" class="btn btn-primary btn-sm my-2">Edit</a>

                        
                        
                        <a href="#" data-id="'.$row->id.'" class="btn btn-danger btn-sm delete-product my-2">Delete</a>
                    ';
                })->filter(function ($instance) use ($request) {
    
                    if ($request->search) {
                        $instance->where(function ($w) use ($request) {
                            $w->where('products.product_name', 'LIKE', "%{$request->search}%");
                        });
                    }
    
                    if ($request->from_date) {
                        $instance->whereDate('products.created_at', '>=', $request->from_date);
                    }
    
                    if ($request->to_date) {
                        $instance->whereDate('products.updated_at', '<=', $request->to_date);
                    }
    
                    if ($request->status) {
                        $instance->where('products.status', $request->status);
                    }

                    if ($request->admin_verify) {
                        $instance->where('products.admin_verify', $request->admin_verify);
                    }
    
                })

                ->rawColumns(['image','action','category','unit'])
                ->make(true);
        } 

        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        try
        {
            $this->productService->store($request->validated());

            return redirect()->back()->with([
                'messege' => 'Product created successfully',
                'alert-type' => 'success'
            ]);

            return redirect()->back()->with($notification);
        }catch(\Exception $e){
            Log::error('Product Store Error', [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
            'code'    => $e->getCode(),
            'trace'   => $e->getTraceAsString(),
        ]);
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try
        {
            $this->productService->update($request->validated(), $product);

            return redirect('/products')->with([
                'messege' => 'Product updated successfully',
                'alert-type' => 'success'
            ]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try
        {
            $this->productService->delete($product);

            return response()->json([
                'message' => 'Product deleted successfully'
            ]);

        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function statusUpdate(Request $request)
    {
        try
        {
            $this->productService->updateStatus(
                $request->product_id,
                $request->status
            );

            return response()->json([
                'message' => 'Status updated successfully'
            ]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function addDeliveryCharge($id)
    {   
        $charge = Productdeliverycharge::where('product_id',$id)->first();
        return view('admin.products.add_delivery_charge',compact('id','charge'));
    }

    public function saveProductDeliveryCharge(DeliveryChargeRequest $request,$id)
    {
        try
        {
            Productdeliverycharge::updateOrCreate(
            [
                'product_id' => $id,
            ],
            [   
                'vendor_id'          => user()->vendor->id,
                'inside_base_charge' => $request->inside_base_charge,
                'outside_base_charge' => $request->outside_base_charge,
                'per_weight_charge' => $request->per_weight_charge,
                'product_weight' => $request->product_weight,
            ]
            );
            $notification=array(
                'messege'=>"Successfully Updated",
                'alert-type'=>"success",
            );

            return redirect('/products')->with($notification);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
