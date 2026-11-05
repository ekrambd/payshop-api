<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\AdminField;
use DB;
use DataTables;
class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_check');
    }
    public function index()
    {
        return view('admin.roles.index');
    }

    public function roleLists(Request $request)
    {
        if($request->ajax())
        {   

            $ids = [1,2,3];
            $data=Role::whereNotIn('id',$ids)->latest()->get();

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action',function($row){

                    return '

                    <a href="'.url('/role-details/'.$row->id).'" class="btn btn-primary btn-sm">

                    <i class="fa fa-edit"></i>

                    </a>

                    <button class="btn btn-danger btn-sm delete-role"

                    data-id="'.$row->id.'">

                    <i class="fa fa-trash"></i>

                    </button>

                    ';

                })

                ->rawColumns(['action'])

                ->make(true);
        }

        return view('admin.roles.index');
    }

    public function addRole()
    {
        return view('admin.roles.create');
    }

    public function saveRole(Request $request)
    {   
        DB::beginTransaction();
        try
        {
            $request->validate([
                'role_name' => 'required|unique:roles,role_name',
            ]);

            $role = Role::create([
                'role_name' => $request->role_name,
            ]);

            AdminField::create([

                'role_id' => $role->id,

                'slider_add' => $request->has('slider_add') ? 'Yes' : 'No',
                'slider_edit' => $request->has('slider_edit') ? 'Yes' : 'No',
                'slider_lists' => $request->has('slider_lists') ? 'Yes' : 'No',
                'slider_delete' => $request->has('slider_delete') ? 'Yes' : 'No',
                'slider_status_update' => $request->has('slider_status_update') ? 'Yes' : 'No',

                'category_add' => $request->has('category_add') ? 'Yes' : 'No',
                'category_edit' => $request->has('category_edit') ? 'Yes' : 'No',
                'category_lists' => $request->has('category_lists') ? 'Yes' : 'No',
                'category_delete' => $request->has('category_delete') ? 'Yes' : 'No',
                'category_status_update' => $request->has('category_status_update') ? 'Yes' : 'No',

                'subcategory_add' => $request->has('subcategory_add') ? 'Yes' : 'No',
                'subcategory_edit' => $request->has('subcategory_edit') ? 'Yes' : 'No',
                'subcategory_lists' => $request->has('subcategory_lists') ? 'Yes' : 'No',
                'subcategory_delete' => $request->has('subcategory_delete') ? 'Yes' : 'No',
                'subcategory_status_update' => $request->has('subcategory_status_update') ? 'Yes' : 'No',

                'unit_add' => $request->has('unit_add') ? 'Yes' : 'No',
                'unit_edit' => $request->has('unit_edit') ? 'Yes' : 'No',
                'unit_lists' => $request->has('unit_lists') ? 'Yes' : 'No',
                'unit_delete' => $request->has('unit_delete') ? 'Yes' : 'No',
                'unit_status_update' => $request->has('unit_status_update') ? 'Yes' : 'No',

                'variant_add' => $request->has('variant_add') ? 'Yes' : 'No',
                'vairant_edit' => $request->has('vairant_edit') ? 'Yes' : 'No',
                'variant_lists' => $request->has('variant_lists') ? 'Yes' : 'No',
                'variant_delete' => $request->has('variant_delete') ? 'Yes' : 'No',

                'vendor_lists' => $request->has('vendor_lists') ? 'Yes' : 'No',
                'vendor_product_verify' => $request->has('vendor_product_verify') ? 'Yes' : 'No',
                'vendor_product_status_change' => $request->has('vendor_product_status_change') ? 'Yes' : 'No',
                'vendor_product_lists' => $request->has('vendor_product_lists') ? 'Yes' : 'No',
                'vendor_edit_requests' => $request->has('vendor_edit_requests') ? 'Yes' : 'No',

            ]);

            $notification=array(
                'messege'=>"Succesfully Added",
                'alert-type'=>"success",
            );

            DB::commit();

            return redirect()->back()->with($notification);

            }catch(\Exception $e){
                DB::rollback();
                return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
            }
    }

    public function roleDetails($id)
    {
        $role = Role::with('AdminField')->findOrFail($id);

        $permission = $role->AdminField;

        return view('admin.roles.edit', compact(
            'role',
            'permission'
        ));
    }

    public function updateRole(Request $request, $id)
    {
        try
        {
            $request->validate([
                'role_name' => 'required|unique:roles,role_name,' . $id,
            ]);

            Role::where('id', $id)->update([
                'role_name' => $request->role_name,
            ]);

            AdminField::where('role_id', $id)->update([

                'slider_add' => $request->has('slider_add') ? 'Yes' : 'No',
                'slider_edit' => $request->has('slider_edit') ? 'Yes' : 'No',
                'slider_lists' => $request->has('slider_lists') ? 'Yes' : 'No',
                'slider_delete' => $request->has('slider_delete') ? 'Yes' : 'No',
                'slider_status_update' => $request->has('slider_status_update') ? 'Yes' : 'No',

                'category_add' => $request->has('category_add') ? 'Yes' : 'No',
                'category_edit' => $request->has('category_edit') ? 'Yes' : 'No',
                'category_lists' => $request->has('category_lists') ? 'Yes' : 'No',
                'category_delete' => $request->has('category_delete') ? 'Yes' : 'No',
                'category_status_update' => $request->has('category_status_update') ? 'Yes' : 'No',

                'subcategory_add' => $request->has('subcategory_add') ? 'Yes' : 'No',
                'subcategory_edit' => $request->has('subcategory_edit') ? 'Yes' : 'No',
                'subcategory_lists' => $request->has('subcategory_lists') ? 'Yes' : 'No',
                'subcategory_delete' => $request->has('subcategory_delete') ? 'Yes' : 'No',
                'subcategory_status_update' => $request->has('subcategory_status_update') ? 'Yes' : 'No',

                'unit_add' => $request->has('unit_add') ? 'Yes' : 'No',
                'unit_edit' => $request->has('unit_edit') ? 'Yes' : 'No',
                'unit_lists' => $request->has('unit_lists') ? 'Yes' : 'No',
                'unit_delete' => $request->has('unit_delete') ? 'Yes' : 'No',
                'unit_status_update' => $request->has('unit_status_update') ? 'Yes' : 'No',

                'variant_add' => $request->has('variant_add') ? 'Yes' : 'No',
                'vairant_edit' => $request->has('vairant_edit') ? 'Yes' : 'No',
                'variant_lists' => $request->has('variant_lists') ? 'Yes' : 'No',
                'variant_delete' => $request->has('variant_delete') ? 'Yes' : 'No',

                'vendor_lists' => $request->has('vendor_lists') ? 'Yes' : 'No',
                'vendor_product_verify' => $request->has('vendor_product_verify') ? 'Yes' : 'No',
                'vendor_product_status_change' => $request->has('vendor_product_status_change') ? 'Yes' : 'No',
                'vendor_product_lists' => $request->has('vendor_product_lists') ? 'Yes' : 'No',
                'vendor_edit_requests' => $request->has('vendor_edit_requests') ? 'Yes' : 'No',

            ]);

            $notification=array(
                    'messege'=>"Succesfully Updated",
                    'alert-type'=>"success",
                );

            return redirect('/role-lists')->with($notification);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function deleteRole(Request $request)
    {
       
        DB::beginTransaction();
        try
        {
            AdminField::where('role_id',$id)->delete();

            Role::find($id)->delete();

            DB::commit();

            return response()->json([

                'status'=>true,

                'message'=>'Role Deleted Successfully'

            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }

    }
}
