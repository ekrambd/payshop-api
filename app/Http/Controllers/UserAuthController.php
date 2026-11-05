<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function userSignup(Request $request)
    {
    	try
    	{    
    	    if($request->has('email'))
    	    {
    	    	$countEmail = User::where('email',$request->email)->count();
	    		if($countEmail > 0){
	    			return response()->json(['status'=>false, 'message'=>'The email has already been taken']);
	    		}
    	    }

    	    $countPhone = User::where('phone',$request->phone)->count();
    		if($countPhone > 0){
    			return response()->json(['status'=>false, 'message'=>'The phone has already been taken']);
    		}

    		if($request->password != $request->confirm_password){
    			return response()->json(['status'=>false, 'message'=>'Password and Confirm Password not same']);
    		} 
    		
    		$user = new User();
    		$user->role_id = 3;
    		$user->name = $request->name;
    		$user->email = $request->email;
    		$user->phone = $request->phone;
    		$user->password = bcrypt($request->password);
    		$user->save();
    		Auth::login($user);
    		return response()->json(['status'=>true, 'message'=>'Successfully signup']);
    	}catch(\Exception $e){
    		return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
    	}
    }

    public function userSignin(Request $request)
    {
    	try
    	{
    		$user = User::where('phone',$request->login)->orWhere('email',$request->email)->first();
            if($user)
            {
                Auth::login($user);
               return response()->json(['status'=>true, 'message'=>'Successfully signin']);
            }

            return response()->json(['status'=>false, 'message'=>'Invalid Credential']);
    		
    	}catch(\Exception $e){
    		return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);
    	}
    }

    public function userLogout()
    {
    	Auth::logout();
    	return redirect('/');
    }

    public function userAuth()
    {
        return view('user_auth_page');
    }

    public function myAccount()
    {   
        $data = Order::with([
            'user',
            'orderDetails.product',
            'orderDetails.variant',
            'orderDetails.productVariant'
        ])
        // ->whereHas('orderDetails', function ($q) {
        //     $q->where('user_id', user()->id);
        // })
        ->where('user_id',user()->id)
        ->orderByDesc('id')
        ->get();
       //return $data;         
        return view('my_account',compact('data')); 
    }

    public function userProfileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:6',
            'confirm_password' => 'same:new_password',
        ]);

        $user = User::findOrFail(Auth::id());

        $user->name = $request->name;

        // Password Change
        if ($request->filled('new_password')) {

            if (!$request->filled('current_password')) {
                return back()->with('error', 'Current password is required.');
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect.');
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        //return back()->with('success', 'Profile updated successfully.');

        return back();
    }
}
