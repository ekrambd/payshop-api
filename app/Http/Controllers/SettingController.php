<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrencySetting;
use App\Models\CommissionSetting;
use Auth;
use Hash;

class SettingController extends Controller
{   

	public function __construct()
    {
        $this->middleware('auth_check');
    }

    public function currencySettings()
    {   
    	$setting = currency();
    	return view('admin.settings.currency_settings', compact('setting'));
    }

    public function currencySettingsUpdate(Request $request)
    {
    	CurrencySetting::updateOrCreate(
        ['id' => 1],
        $request->except('_token')
    );

    $notification = [
        'messege' => 'Currency settings updated successfully',
        'alert-type' => 'success',
    ];

    return redirect()->back()->with($notification);
    }

    public function changePassword()
    {
        return view('settings.change_password');
    }

    public function passwordChange(PasswordChangeRequest $request)
    {
        try
        {
            $user = User::find(user()->id);
            //$message = $user->changePassword($request,$user);

            if (!Hash::check($request->current_password, $user->password)) {
            
               $message = ['message'=>'The current password is incorrect.', 'type'=>'error'];
            }

            $user->password = Hash::make($request->new_password);
            $user->update();

            $message = ['message'=>'Your password has been changed', 'type'=>'success'];

            $notification=array(
                 'messege'=>$message['message'],
                 'alert-type'=>$message['type']
            );

            return Redirect()->back()->with($notification);


        }catch(\Exception $e){
                  
                $message = $e->getMessage();
      
                $code = $e->getCode();       
      
                $string = $e->__toString();       
                return response()->json(['message'=>$message, 'execption_code'=>$code, 'execption_string'=>$string]);
                exit;
        }
    }

    public function commissionSettings()
    {   
        $data = CommissionSetting::find(1);
        return view('admin.settings.commission_settings',compact('data'));
    }

    public function saveCommissionFee(Request $request)
    {
        try
        {
            $fee = CommissionSetting::find(1);
            $fee->user_id = user()->id;
            $fee->sell_fee = $request->sell_fee;
            $fee->verify_fee = $request->verify_fee;
            $fee->update(); 

            $notification=array(
                 'messege'=>"Successfully update",
                 'alert-type'=>"success"
            );

            return Redirect()->back()->with($notification);

        }catch(\Exception $e){
                  
            return response()->json(['status'=>false, 'code'=>$e->getCode(), 'message'=>$e->getMessage()],500);

        }
    }
}
