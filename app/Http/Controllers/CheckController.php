<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use Auth;
use Illuminate\Support\Facades\File;
use DB;
use App\Models\Vendoreditrequest;
use App\Models\Variant;
use App\Models\ProductVariant;

class CheckController extends Controller
{   

	public function __construct()
    {
        $this->middleware('auth_check');
    }

    public function vendorLists(Request $request)
    {
    	if ($request->ajax()) {

            $vendors = User::with('vendor')->where('role_id',2)->latest();

            return Datatables::of($vendors)
                ->addIndexColumn()


                ->addColumn('shop_name', function ($row) {

                    return $row->vendor->shop_name;
                })


                ->addColumn('status', function ($row) {

                    $checked = $row->status === 'Active' ? 'checked' : '';

                    $class = $row->status === 'Active'
                        ? 'active-vendor'
                        : 'decline-vendor';

                    return '
                        <label class="switch">
                            <input 
                                type="checkbox"
                                class="' . $class . '"
                                id="status-vendor-update"
                                data-id="' . $row->id . '"
                                ' . $checked . '
                            >
                            <span class="slider round"></span>
                        </label>
                    ';
                })



                ->addColumn('action', function ($row) {

                    //$viewURL = route('users.show', $row->id);

                    $viewURL = url('/vendor-details/'.$row->id);

                    return '
                        <a href="' . $viewURL . '" class="btn btn-primary btn-sm action-button show-vendor" data-id="' . $row->id . '">
                            <i class="fa fa-eye"></i>
                        </a>

                        <a href="#" class="btn btn-danger btn-sm delete-vendor action-button" data-id="' . $row->id . '">
                            <i class="fa fa-trash"></i>
                        </a>
                    ';
                })->filter(function ($instance) use ($request) {
    
                    if ($request->search) {
                        $instance->where(function ($w) use ($request) {
                            $w->where('users.name', 'LIKE', "%{$request->search}%")->orWhere('users.email', 'LIKE', "%{$request->search}%")->orWhere('users.phone', 'LIKE', "%{$request->search}%");
                        });
                    }
    
    
                    if ($request->status) {
                        $instance->where('users.status', $request->status);
                    }
    
                })

                ->rawColumns(['action', 'status', 'shop_name'])
                ->make(true);
        }

        return view('admin.vendors.index');
    }

    public function vendorDetails($id)
    {
    	 $user = User::with('vendor')
                    ->findOrFail($id);

        return view('admin.vendors.profile', compact('user'));
    }

    public function vendorStatusUpdate(Request $request)
    {
    	try
    	{
    		$user = User::findorfail($request->vendor_id);
    		$user->status = $request->status;
    		$user->update();
    		return response()->json(['status'=>true, 'message'=>"Successfully {$user->status}"]);
    	}catch(\Exception $e){
    		return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
    	}
    }

    public function deleteVendor($id)
    {
    	DB::beginTransaction();

	    try {

	        $user = User::with(['vendor', 'products'])->findOrFail($id);

	        // ================= Delete Vendor Files =================
	        if ($user->vendor) {

	            $vendorFiles = [
	                $user->vendor->nid_front,
	                $user->vendor->nid_back,
	                $user->vendor->selfie_photo,
	                $user->vendor->tin_file,
	                $user->vendor->bin_file,
	                $user->vendor->cancelled_cheque,
	            ];

	            foreach ($vendorFiles as $file) {

	                if (!empty($file) && File::exists(public_path($file))) {
	                    File::delete(public_path($file));
	                }

	            }

	        }

	        // ================= Delete Product Images =================
	        foreach ($user->products as $product) {

	            if (
	                !empty($product->product_image) &&
	                File::exists(public_path($product->product_image))
	            ) {
	                File::delete(public_path($product->product_image));
	            }

	            $product->delete();

	        }

	        // ================= Delete User Image =================
	        if (
	            !empty($user->image) &&
	            $user->image != 'defaults/profile.png' &&
	            File::exists(public_path($user->image))
	        ) {
	            File::delete(public_path($user->image));
	        }

	        // ================= Delete User =================
	        // vendors table will automatically delete because of cascadeOnDelete()
	        $user->delete();

	        DB::commit();

	        return response()->json([
	            'status'  => true,
	            'message' => 'Vendor deleted successfully.'
	        ]);

	    } catch (\Exception $e) {

	        DB::rollBack();

	        return response()->json([
	            'status'  => false,
	            'code'    => $e->getCode(),
	            'message' => $e->getMessage()
	        ], 500);

	    }
    }

    public function vendorProducts(Request $request)
    {
    	if ($request->ajax()) {

            $products = Product::where('user_id','!=',1)->latest();

            return datatables()->of($products)
                ->addIndexColumn()

                ->addColumn('image', function ($row) {
                    return '<img src="'.asset($row->featured_image).'" width="60">';
                })

                ->addColumn('category', function ($row) {
                    return $row->category->category_name;
                })

                ->addColumn('vendor_name', function ($row) {
                    return $row->user->name;
                })

                ->addColumn('vendor_phone', function ($row) {
                    return $row->user->phone;
                })

                ->addColumn('vendor_shop', function ($row) {
                    return $row->user->vendor->shop_name;
                })

                ->addColumn('unit', function ($row) {
                    return $row->unit->unit_name;
                })


                ->addColumn('status', function ($row) {

                    $checked = $row->status == 'Active' ? 'checked' : '';

                    return '
                        <label class="switch">
                            <input type="checkbox"
                                id="status-product-admin-update"
                                data-id="'.$row->id.'"
                                '.$checked.'>
                            <span class="slider round"></span>
                        </label>
                    ';
                })

                ->addColumn('admin_verify', function ($row) {

                    $checked = $row->admin_verify == 'Yes' ? 'checked' : '';

                    return '
                        <label class="switch">
                            <input type="checkbox"
                                id="status-product-verify"
                                data-id="'.$row->id.'"
                                '.$checked.'>
                            <span class="slider round"></span>
                        </label>
                    ';
                })

                ->addColumn('action', function ($row) {
                	$showURL = url('/view-product-details/'.$row->id);
                    return '

                        &nbsp;
                        <a href="'.$showURL.'" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>

                        &nbsp;
                        
                        <a href="#" data-id="'.$row->id.'" class="btn btn-danger btn-sm delete-product"><i class="fa fa-trash"></i></a>
                    ';
                })->filter(function ($instance) use ($request) {
    
                    if ($request->search) {
                        $instance->where(function ($w) use ($request) {
                            $w->where('products.product_name', 'LIKE', "%{$request->search}%");
                        });
                    }

                    if ($request->vendor_id) {
                        $instance->where('products.user_id', $request->vendor_id);
                    }
    
                    if ($request->status) {
                        $instance->where('products.status', $request->status);
                    }

                    if ($request->admin_verify) {
                        $instance->where('products.admin_verify', $request->admin_verify);
                    }
    
                })

                ->rawColumns(['image','admin_verify','action','category','unit','vendor_name','vendor_phone','vendor_shop','status'])
                ->make(true);
        }

        return view('admin.vendors.products');
    }

    public function productStatusVerify(Request $request)
    {
    	try
    	{
    		$product = Product::findorfail($request->product_id);
    		$product->admin_verify = $request->admiVerify;
    		$product->update();
    		$message = $product->admin_verify == 'Yes'?"Successfully Verified By Admin":"Successfully UnVerified By Admin";
    		return response()->json(['status'=>true, 'message'=>"Successfully {$message}"]);
    	}catch(\Exception $e){
    		return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
    	}
    }

    public function viewProductDetails($id)
    {
    	$product = Product::with('category','unit')->findorfail($id);
    	return view('admin.vendors.product_details', compact('product'));
    }

    public function vendorEditRequests(Request $request)
    {
        if ($request->ajax()) {

            $data = Vendoreditrequest::with('user','vendor')
                ->latest()
                ->get();

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('vendor', function ($row) {

                    return $row->user->name ?? 'N/A';

                })

                ->addColumn('field_name', function ($row) {

                    return ucfirst(str_replace('_',' ',$row->field_name));

                })

                ->addColumn('old_value', function ($row) {

                    if($row->old_file){
                        return '<a href="'.asset($row->old_file).'" target="_blank" class="btn btn-sm btn-info">View File</a>';
                    }

                    return $row->old_value;

                })

                ->addColumn('new_value', function ($row) {

                    if($row->new_file){
                        return '<a href="'.asset($row->new_file).'" target="_blank" class="btn btn-sm btn-primary">View File</a>';
                    }

                    return $row->new_value;

                })

                ->addColumn('status', function ($row) {

                    if($row->status=='Pending'){
                        return '<span class="badge badge-warning">Pending</span>';
                    }

                    if($row->status=='Approved'){
                        return '<span class="badge badge-success">Approved</span>';
                    }

                    return '<span class="badge badge-danger">Rejected</span>';

                })

                ->addColumn('change_status', function ($row) {

                if ($row->status == 'Approved') {

                    return '

                        <select class="form-control form-control-sm" disabled>

                            <option value="Approved" selected>
                                Approved
                            </option>

                            <option value="Pending" disabled>
                                Pending
                            </option>

                            <option value="Rejected" disabled>
                                Rejected
                            </option>

                        </select>

                    ';
                }

                $pending = $row->status == 'Pending' ? 'selected' : '';
                $rejected = $row->status == 'Rejected' ? 'selected' : '';

                return '

                    <select class="form-control form-control-sm change-edit-request-status"
                            data-id="'.$row->id.'">

                        <option value="Pending" '.$pending.'>
                            Pending
                        </option>

                        <option value="Approved">
                            Approved
                        </option>

                        <option value="Rejected" '.$rejected.'>
                            Rejected
                        </option>

                    </select>

                ';
            })

                ->addColumn('action', function ($row) {

                    $redirectURL = url('/')."/vendor-details/".$row->user_id;
                    return '

                        <a href="'.$redirectURL.'" class="btn btn-info btn-sm">
                            View Vendor Profile
                        </a>

                    ';

                })

                ->rawColumns([
                    'old_value',
                    'new_value',
                    'status',
                    'change_status',
                    'action'
                ])

                ->make(true);
        }

       return view('admin.vendors.edit_requests');
    }

    public function vendorRequestStatus(Request $request,$id)
    {
        try
        {  

            $requestData = Vendoreditrequest::findOrFail($id);
            if ($request->status == 'Approved') {

                $userFields = [
                    'name',
                    'email',
                    'phone',
                    'image'
                ];

                if (in_array($requestData->field_name, $userFields)) {

                    $user = User::find($requestData->user_id);

                    if ($requestData->new_file) {

                        if ($requestData->old_file && file_exists(public_path($requestData->old_file))) {
                            unlink(public_path($requestData->old_file));
                        }

                        $user->{$requestData->field_name} = $requestData->new_file;

                    } else {

                        $user->{$requestData->field_name} = $requestData->new_value;

                    }

                    $user->save();

                } else {

                    $vendor = Vendor::find($requestData->vendor_id);

                    if ($requestData->new_file) {

                        if ($requestData->old_file && file_exists(public_path($requestData->old_file))) {
                            unlink(public_path($requestData->old_file));
                        }

                        $vendor->{$requestData->field_name} = $requestData->new_file;

                    } else {

                        $vendor->{$requestData->field_name} = $requestData->new_value;

                    }

                    $vendor->save();

                }

                $requestData->approved_by = auth()->id();
                $requestData->approved_at = now();
            }

            $requestData->status = $request->status;
            $requestData->update();

            return response()->json(['status'=>true, 'message'=>"Successfully {$request->status}"]);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }

    public function deleteVariant($id)
    {
        try
        {
            $variant = ProductVariant::findorfail($id);
            $variant->delete();
            return response()->json(['status'=>true, 'message'=>'Successfully the variant has been deleted']);
        }catch(\Exception $e){
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
        }
    }
}
