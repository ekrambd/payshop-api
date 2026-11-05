<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Cart;

class OrderController extends Controller
{
    public function saveOrder(Request $request)
    {
        DB::beginTransaction();

        try {

            

            $cartSession = Session::get('cart_session_id');

            if (!$cartSession) {
                return back()->with('error', 'Cart is empty.');
            }

            $carts = Cart::where('cart_session_id', $cartSession)->get();

            if ($carts->count() == 0) {
                return back()->with('error', 'Cart is empty.');
            }

            $subtotal = $carts->sum('unit_total');

            $vat = 0;

            $total = $subtotal + $vat;

            $count = Order::count();
            $count+=1;

            $invoice = 'INV-00'.$count;

            $order = Order::create([
                'user_id'           => auth()->check()?user()->id:null,
                'payment_method_id' => 1,
                'invoice_no'        => $invoice,
                'date'              => now()->format('Y-m-d'),
                'time'              => now()->format('h:i:s A'),
                'timestamp'         => now()->timestamp,
                'sub_total'         => $subtotal,
                'vat_tax'           => $vat,
                'total'             => $total,
                'user_name'         => $request->user_name,
                'user_email'        => $request->user_email,
                'user_phone'        => $request->user_phone,
                'user_address'      => $request->user_address,
                'user_city'         => $request->user_city,
                'user_country'      => $request->user_country,
                'user_zipcode'      => $request->user_zipcode,
                'delivery_charge'   => $request->delivery_charge,
                'order_type'        => auth()->check()
                                        ? 'authetic_order'
                                        : 'direct_order',

                                     
            ]);

            foreach ($carts as $cart) { 

                $product = Product::find($cart->product_id);

                OrderDetail::create([

                    'order_id'            => $order->id,
                    'user_id'             => $product->user_id,
                    'product_id'          => $cart->product_id,
                    'current_symbol'      => $product->current_symbol,
                    'variant_id'          => $cart->variant_id, 
                    'product_variant_id'  => $cart->product_variant_id,
                    'payment_method_id'   => 1,
                    'purchase_price'      => $cart->cart_price,
                    'purchase_discount'   => $product->product_discount ?? 0,
                    'qty'                 => $cart->cart_qty,
                    'status'              => 'Pending',

                ]);

            }

            Cart::where('cart_session_id', $cartSession)->delete();

            Session::forget('cart_session_id');

            DB::commit();

            return redirect('/success-order');

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json(['message'=>$e->getMessage()],500);

        }
    }

    public function successOrder()
    {
        return view('success_order');
    }
}
