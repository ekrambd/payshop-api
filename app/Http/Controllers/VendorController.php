<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use App\Http\Requests\VendorSignupRequest;
use DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class VendorController extends Controller
{
    public function vendorSignup()
    {
    	return view('vendor_signup');
    }

    public function saveVendor(VendorSignupRequest $request)
    {
    	DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Upload Files
            |--------------------------------------------------------------------------
            */

            $nidFront = null;
            $nidBack = null;
            $selfie = null;
            $tinFile = null;
            $binFile = null;
            $cancelCheque = null;

            if ($request->hasFile('nid_front')) {

                $file = $request->file('nid_front');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $nidFront = 'uploads/vendors/'.$name;
            }

            if ($request->hasFile('nid_back')) {

                $file = $request->file('nid_back');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $nidBack = 'uploads/vendors/'.$name;
            }

            if ($request->hasFile('selfie_photo')) {

                $file = $request->file('selfie_photo');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $selfie = 'uploads/vendors/'.$name;
            }

            if ($request->hasFile('tin_file')) {

                $file = $request->file('tin_file');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $tinFile = 'uploads/vendors/'.$name;
            }

            if ($request->hasFile('bin_file')) {

                $file = $request->file('bin_file');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $binFile = 'uploads/vendors/'.$name;
            }

            if ($request->hasFile('cancelled_cheque')) {

                $file = $request->file('cancelled_cheque');

                $name = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $cancelCheque = 'uploads/vendors/'.$name;
            }
            
            if($request->file('trade_file'))
            {
                $file = $request->file('trade_file');

                $name = time().'trade_'.uniqid().'.'.$file->getClientOriginalExtension();

                $file->move(public_path('uploads/vendors'), $name);

                $tradeFile = 'uploads/vendors/'.$name;
            }else{
                $tradeFile = NULL;
            }

            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            $user = User::create([

                'name' => $request->name,

                'email' => $request->email,

                'phone' => $request->phone,

                'role_id' => 2,

                'password' => Hash::make($request->password),

            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Vendor
            |--------------------------------------------------------------------------
            */

            Vendor::create([

                'user_id' => $user->id,

                'shop_name' => $request->shop_name,

                'nid_number' => $request->nid_number,

                'nid_front' => $nidFront,

                'nid_back' => $nidBack,

                'selfie_photo' => $selfie,

                'trade_license_no' => $request->trade_license_no,
                
                'trade_file' => $tradeFile,

                'tin_no' => $request->tin_no,

                'tin_file' => $tinFile,

                'bin_no' => $request->bin_no,

                'bin_file' => $binFile,

                'bank_name' => $request->bank_name,

                'branch_name' => $request->branch_name,

                'account_name' => $request->account_name,

                'account_number' => $request->account_number,

                'cancelled_cheque' => $cancelCheque,

                'pickup_address' => $request->pickup_address,

                'return_address' => $request->return_address,

                'district' => $request->district,

                'routing_number' => $request->routing_number,

            ]);

            DB::commit();

            return redirect('/vendor-login');

            // return redirect()
            //     ->route('vendor.signup.form')
            //     ->with('success', 'Vendor account created successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());

        }
    }

    public function vendorLogin()
    {
    	return view('vendor_login');
    }

    public function vendorSignin(Request $request)
	{
	    try {

	        $data = $request->all();

	        if (Auth::attempt([
	            'email'    => $data['email'],
	            'password' => $data['password'],
	            'role_id'  => 2,
	        ])) {

	            $notification = [
	                'messege'   => 'Successfully Logged In',
	                'alert-type'=> 'success'
	            ];

	            return redirect('/dashboard')->with($notification);

	        } else {

	            $notification = [
	                'messege'   => 'Invalid email, password or you are not a vendor.',
	                'alert-type'=> 'error'
	            ];

	            return redirect()->back()->with($notification);

	        }

	    } catch (\Exception $e) {

	    	return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
	        // return back()
	        //     ->withInput()
	        //     ->with('error', $e->getMessage());
	    }
	}

	public function vendorLogout()
	{
		Auth::logout();
		return redirect('/vendor-login');
	}
}
