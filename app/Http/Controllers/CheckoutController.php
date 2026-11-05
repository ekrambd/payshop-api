<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\DeliveryChargeSetting;

class CheckoutController extends Controller
{
    public function checkout()
    {   
        $sum = Cart::selectRaw('MAX(unit_total) as total')
		    ->where('cart_session_id', Session::get('cart_session_id'))
		    ->groupBy('product_id')
		    ->pluck('total')
		    ->sum();
		    
		if($sum == 0)
		{
		    return back();
		}

         // $charge = DeliveryChargeSetting::find(1);

         // $perAmt = $charge->inside_city_charge / 100;

         // $delivery_charge = $sum * $perAmt;

         //return $sum * ($charge->inside_city_charge / 100);

        $delivery_charge = 0;

        $cartItems  = Cart::with('product.productdeliverycharge')->where('cart_session_id',Session::get('cart_session_id'))->get();

        $vendors = $cartItems->groupBy('vendor_id');

        $totalDelivery = 0;

        foreach($vendors as $vendorId => $items){
            $baseCharge = $items->max(function($item){

                return $item->product->productdeliverycharge->inside_base_charge;

            });


            $weightCharge = 0;

            foreach($items as $item)
            {


                $charge = $item->product->productdeliverycharge;


                $weightCharge +=
                    (
                        $charge->product_weight 
                        *
                        $item->cart_qty
                    )
                    *
                    $charge->per_weight_charge;


            }

            $vendorDelivery = 
            $baseCharge + $weightCharge;



            $totalDelivery += $vendorDelivery;

        }

        $delivery_charge = $totalDelivery;

        $getCurrency = Session::get('currency');

        $amount = currency()->$getCurrency;

        $delivery_charge = ceil($delivery_charge * $amount); 

        $paymentMethods = PaymentMethod::get();
    	return view('checkout',compact('sum','paymentMethods','delivery_charge')); 
    }
}
