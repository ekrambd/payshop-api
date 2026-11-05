<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\Category\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(
        protected CategoryService $categoryService
    ){
        $this->middleware('auth_check');
    }

    public function index(Request $request) 
    {
        if ($request->ajax()) {

            $categories = $this->categoryService->fetch()->latest()->get();

            return Datatables::of($categories)
                ->addIndexColumn()


                ->addColumn('status', function ($row) {

                    $checked = $row->status === 'Active' ? 'checked' : '';

                    $class = $row->status === 'Active'
                        ? 'active-category'
                        : 'decline-category';

                    return '
                        <label class="switch">
                            <input 
                                type="checkbox"
                                class="' . $class . '"
                                id="status-category-update"
                                data-id="' . $row->id . '"
                                ' . $checked . '
                            >
                            <span class="slider round"></span>
                        </label>
                    ';
                })

                // ================= IMAGE =================
                ->addColumn('image', function ($row) {

                    return '
                        <img src="' . asset('uploads/categories/' . $row->image) . '"
                            alt="category image"
                            class="img-fluid"
                            style="width:80px;height:50px;object-fit:cover;border-radius:5px;">
                    ';
                })


                ->addColumn('action', function ($row) {

                    $editUrl = route('categories.show', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-primary btn-sm action-button edit-category" data-id="' . $row->id . '">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a href="#" class="btn btn-danger btn-sm delete-category action-button" data-id="' . $row->id . '">
                            <i class="fa fa-trash"></i>
                        </a>
                    ';
                })

                ->rawColumns(['action', 'status', 'image'])
                ->make(true);
        }

        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        try
        {
            $category = $this->categoryService->store($request->all());
        
            $notification=array(
                'messege'=>$category?successMessage("category","add"):errorMessage("category","update"),
                'alert-type'=>$category?"success":"error",
            );

            return redirect()->back()->with($notification);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {   
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try
        {
            $category = $this->categoryService->update($request->all(), $category);
        
            $notification=array(
                'messege'=>$category?successMessage("category","update"):errorMessage("category","update"),
                'alert-type'=>$category?"success":"error",
            );

            return redirect('/categories')->with($notification);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try
        {
            $category = $this->categoryService->delete($category);
        
            if(!$category){
                return response()->json(['status'=>false, 'message'=>errorMessage("category","delete")],403);
            }
            return response()->json(['status'=>true, 'message'=>successMessage("category","delete")],200);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function categoryStatusUpdate(Request $request)
    {
        try
        {   
            $category = $this->categoryService->fetch()->where('id',$request->category_id)->first();
            $category = $this->categoryService->statusUpdate(
                $category,
                $request->status
            );

            return response()->json([
                'status' => true,
                'message' => "Successfully updated",
                'data' => $category
            ]);
            
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
