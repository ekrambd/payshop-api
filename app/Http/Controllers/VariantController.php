<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Variant;
use App\Models\ProductVariant;
use App\Services\Variant\VariantService;
use App\Http\Requests\StoreVariantRequest;
use App\Http\Requests\UpdateVariantRequest;
use DataTables;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(
        protected VariantService $variantService
    ) {
        $this->middleware('auth_check');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $variants = $this->variantService->fetch()->latest()->get();

            return datatables()->of($variants)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    return '
                        <a href="' . route('variants.show', $row->id) . '" class="btn btn-primary btn-sm">
                            Edit
                        </a>

                        <a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete-variant">
                            Delete
                        </a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.variants.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.variants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVariantRequest $request)
    {
        try {
            $this->variantService->store($request->validated());

            $notification=array(
                'messege'=>"Variant added successfully",
                'alert-type'=>"success",
            );

            return redirect()->back()->with($notification);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  Variant $variant
     * @return \Illuminate\Http\Response
     */
    public function show(Variant $variant)
    {
        return view('admin.variants.edit', compact('variant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  Variant $variant
     * @return \Illuminate\Http\Response
     */
    public function edit(Variant $variant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  Variant $variant
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVariantRequest $request, Variant $variant)
    {
        try {
            $this->variantService->update($request->validated(), $variant);

            $notification=array(
                'messege'=>"Unit updated successfully",
                'alert-type'=>"success",
            );

            return redirect('/variants')->with($notification);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Variant $variant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variant $variant)
    {
        try {
            $this->variantService->delete($variant);

            return response()->json([
                'status' => true,
                'message' => 'Variant deleted successfully'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Delete failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     /* ================= PRODUCT VARIANT SAVE ================= */
    public function saveProductVariant(Request $request)
    {
        try {

            $this->variantService->saveProductVariant($request->all());

            $notification = [
                'messege' => "Product variants saved successfully",
                'alert-type' => "success",
            ];

            return redirect()->back()->with($notification);

        } catch (\Exception $e) {

            return redirect()->back()->with([
                'messege' => $e->getMessage(),
                'alert-type' => "error",
            ]);
        }
    }

    /* ================= PRODUCT VARIANT DELETE ================= */
    public function deleteProductVariant(ProductVariant $variant)
    {
        try {

            $this->variantService->deleteProductVariant($variant);

            return response()->json([
                'status' => true,
                'message' => "Product variant deleted successfully"
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function addProductVariant($id)
    {   
        //return $id;
        $product = Product::findorfail($id);
        $variants = Variant::with(['productVariants' => function ($query) use ($id) {
            $query->where('product_id', $id);
        }])->get();
        //return $variants;
        return view('admin.products.add_variant', compact('product','variants'));
    }
}
