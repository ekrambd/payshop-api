<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use App\Models\Vendoreditrequest;
use App\Models\DeliveryChargeSetting;

class VendorProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth_check');
    }

    public function vendorProfileSettings()
    {
    	//$vendor = User::with('vendor')->where('id',user()->id)->first();
    	$vendor = Vendor::with('user')->where('user_id',user()->id)->first();
    	return view('vendors.profile', compact('vendor'));
    }

    public function vendorProfileUpdade(Request $request)
    {
    	DB::beginTransaction();

	    try {

	    	$id = user()->vendor->id;

	        $vendor = Vendor::with('user')->findOrFail($id);

	        /*
	        |--------------------------------------------------------------------------
	        | User Table Fields
	        |--------------------------------------------------------------------------
	        */

	        $userFields = [
	            'name',
	            'email',
	            'phone'
	        ];

	        foreach ($userFields as $field) {

	            if ($request->$field != $vendor->user->$field) {

	                Vendoreditrequest::create([
	                    'user_id'    => $vendor->user_id,
	                    'vendor_id'  => $vendor->id,
	                    'field_name' => $field,
	                    'old_value'  => $vendor->user->$field,
	                    'new_value'  => $request->$field,
	                    'status'     => 'Pending'
	                ]);

	            }

	        }

	        /*
	        |--------------------------------------------------------------------------
	        | Vendor Table Fields
	        |--------------------------------------------------------------------------
	        */

	        $vendorFields = [
	            'shop_name',
	            'nid_number',
	            'trade_license_no',
	            'tin_no',
	            'bin_no',
	            'bank_name',
	            'branch_name',
	            'account_name',
	            'account_number',
	            'pickup_address',
	            'return_address'
	        ];

	        foreach ($vendorFields as $field) {

	            if ($request->$field != $vendor->$field) {

	                Vendoreditrequest::create([
	                    'user_id'    => $vendor->user_id,
	                    'vendor_id'  => $vendor->id,
	                    'field_name' => $field,
	                    'old_value'  => $vendor->$field,
	                    'new_value'  => $request->$field,
	                    'status'     => 'Pending'
	                ]);

	            }

	        }

	        /*
	        |--------------------------------------------------------------------------
	        | File Fields
	        |--------------------------------------------------------------------------
	        */

	        $fileFields = [
	            'image',
	            'nid_front',
	            'nid_back',
	            'selfie_photo',
	            'tin_file',
	            'bin_file',
	            'cancelled_cheque'
	        ];

	        foreach ($fileFields as $field) {

	            if ($request->hasFile($field)) {

	                $file = $request->file($field);

	                $filename = time().'_'.$field.'.'.$file->getClientOriginalExtension();

	                $path = 'uploads/vendor_edit_requests/';

	                $file->move(public_path($path), $filename);

	                $oldFile = $field == 'image'
	                    ? $vendor->user->image
	                    : $vendor->$field;

	                Vendoreditrequest::create([
	                    'user_id'    => $vendor->user_id,
	                    'vendor_id'  => $vendor->id,
	                    'field_name' => $field,
	                    'old_file'   => $oldFile,
	                    'new_file'   => $path.$filename,
	                    'status'     => 'Pending'
	                ]);

	            }

	        }

	        DB::commit();

	        $notification=array(
                'messege'=>"Your update request has been submitted successfully",
                'alert-type'=>"success",
            );

            return redirect()->back()->with($notification);

	        //return back()->with('success', 'Your update request has been submitted successfully.');

	    } catch (\Exception $e) {

	        DB::rollBack();

	        return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);

	    }
    }

    public function setDeliveryCharge()
    {   
    	$setting = DeliveryChargeSetting::where('user_id', user()->id)->first();
    	return view('vendors.set_delivery_charge', compact('setting'));
    }

    public function saveDeliveryCharge(Request $request)
    {
    	try
    	{
    		DeliveryChargeSetting::updateOrCreate(
		        [
		            'user_id' => user()->id,
		        ],
		        [
		            'inside_city_charge'  => $request->inside_city_charge,
		            'outside_city_charge' => $request->outside_city_charge,
		            'per_weight_charge'   => $request->per_weight_charge,
		        ]
		    );

		    $notification=array(
                'messege'=>"Succesfully updated",
                'alert-type'=>"success",
            );

            return redirect()->back()->with($notification);
            
    	}catch (\Exception $e) {

	        return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);

	    }
    } 
}
