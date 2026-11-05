<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use DataTables;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth_check');
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {

            $subcategories = Subcategory::with('category')->latest()->get();

            return Datatables::of($subcategories)
                ->addIndexColumn()

                ->addColumn('category', function ($row) {
                    return $row->category?->category_name;
                })

                ->addColumn('status', function ($row) {

                    $checked = $row->status == 'Active' ? 'checked' : '';

                    $class = $row->status == 'Active'
                        ? 'active-subcategory'
                        : 'decline-subcategory';

                    return '
                        <label class="switch">
                            <input type="checkbox"
                                   class="'.$class.'"
                                   id="status-subcategory-update"
                                   data-id="'.$row->id.'"
                                   '.$checked.'>
                            <span class="slider round"></span>
                        </label>
                    ';
                })

                ->addColumn('action', function ($row) {

                    $editUrl = route('subcategories.show', $row->id);

                    return '
                        <a href="'.$editUrl.'" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a href="#" class="btn btn-danger btn-sm delete-subcategory"
                           data-id="'.$row->id.'">
                            <i class="fa fa-trash"></i>
                        </a>
                    ';
                })

                ->rawColumns(['status','action'])
                ->make(true);
        }

        return view('admin.subcategories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subcategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubCategoryRequest $request)
    {
        try{

            Subcategory::create([
                'user_id'=>auth()->id(),
                'category_id'=>$request->category_id,
                'subcategory_name'=>$request->subcategory_name,
                'status'=>$request->status,
            ]);

            $notification=array(
                'messege'=>"Subcategory added successfully",
                'alert-type'=>"success",
            );

            return redirect()->back()->with($notification);

        }catch(\Exception $e){

            return response()->json([
                'status'=>false,
                'code'=>$e->getCode(),
                'message'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        return view('admin.subcategories.edit',compact('subcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubCategoryRequest $request, Subcategory $subcategory)
    {
        try{


            $subcategory->update([
                'category_id'=>$request->category_id,
                'subcategory_name'=>$request->subcategory_name,
                'status'=>$request->status,
            ]);

            $notification=array(
                'messege'=>"Subcategory updated successfully",
                'alert-type'=>"success",
            );

            return redirect('/subcategories')->with($notification);

        }catch(\Exception $e){

            return response()->json([
                'status'=>false,
                'code'=>$e->getCode(),
                'message'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
         try{

            $subcategory->delete();

            return response()->json([
                'status'=>true,
                'message'=>'Subcategory deleted successfully'
            ]);

        }catch(\Exception $e){

            return response()->json([
                'status'=>false,
                'code'=>$e->getCode(),
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function subcategoryStatusChange(Request $request)
    {
        try{

            $subcategory = Subcategory::findOrFail($request->id);

            $subcategory->status = $request->status;

            $subcategory->save();

            return response()->json([
                'status'=>true
            ]);

        }catch(\Exception $e){

            return response()->json([
                'status'=>false,
                'code'=>$e->getCode(),
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function subcategoriesByCategory(Request $request)
    {
        try
        {
            $subcategories = Subcategory::where('category_id',$request->category_id)->latest()->get();
            return response()->json(['status'=>count($subcategories) > 0, 'data'=>$subcategories]);
        }catch(\Exception $e){

            return response()->json([
                'status'=>false,
                'code'=>$e->getCode(),
                'message'=>$e->getMessage()
            ]);
        }
    }
}
