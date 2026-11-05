<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use App\Models\DeliveryChargeSetting;

class Order extends Model
{
    use HasFactory; 

    protected $appends = ['status','current_symbol','weight_price','place_type','order_status'];

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'invoice_no',
        'date',
        'time',
        'timestamp',
        'sub_total',
        'vat_tax',
        'total',
        'user_name',
        'user_email',
        'user_phone',
        'user_address',
        'user_city',
        'user_country',
        'user_zipcode',
        'delivery_charge',
        'order_type'
    ];

    public function orderDetails()
    {
    	return $this->hasMany(OrderDetail::class);
    }

    public function steadfastOrder()
    {
        return $this->hasOne(SteadfastOrder::class, 'order_id')->latest();
    }

    public function steadfastOrders()
    {
        return $this->hasMany(SteadfastOrder::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute()
    {
        $userId = auth()->check() ? auth()->id() : null;
        if ($userId) {
            $data = OrderDetail::where('order_id',$this->id)->where('user_id',$userId)->pluck('status')->toArray();
            if(count($data) > 0)
            {
                $status = array_unique($data);
                return $status[0];
            }
        }
        return $this->order_status;
    }

    public function getOrderStatusAttribute()
    {
        $data = OrderDetail::where('order_id',$this->id)->pluck('status')->toArray();
        if(count($data) > 0)
        {
            $status = array_unique($data);
            return $status[0];
        }    
        return 'Pending';
    }


    public function getCurrentSymbolAttribute()
    {
        $userId = auth()->check() ? auth()->id() : null;
        if ($userId) {
            $data = OrderDetail::where('order_id',$this->id)->where('user_id',$userId)->pluck('current_symbol')->toArray();
            if(count($data) > 0)
            {
                $symbol = array_unique($data);
                return $symbol[0];
            }
        }
        $first = OrderDetail::where('order_id',$this->id)->value('current_symbol');
        return $first ?? '$';
    }

    public function getWeightPriceAttribute()
    {
        $userId = auth()->check() ? auth()->id() : null;
        if (!$userId) return "0";

        $ids = OrderDetail::where('order_id',$this->id)->where('user_id',$userId)->where('product_variant_id','!=',NULL)->where('variant_id',6)->pluck('product_variant_id')->toArray();

        $sumWeight = ProductVariant::whereIn('id',$ids)->sum('variant_value');
        $charge = DeliveryChargeSetting::where('user_id',$userId)->first();
        if($sumWeight > 0 && $charge)
        {
            $sum = $charge->per_weight_charge * $sumWeight; 
            return strval($sum);
        }

        return "0";
    }

    public function getPlaceTypeAttribute()
    {
        $userId = auth()->check() ? auth()->id() : null;
        if ($userId) {
            $data = OrderDetail::where('order_id',$this->id)->where('user_id',$userId)->pluck('place_type')->toArray();
            if(count($data) > 0)
            {
                $type = array_unique($data);
                return $type[0];
            }
        }
        $first = OrderDetail::where('order_id',$this->id)->value('place_type');
        return $first ?? 'inside';
    }

    // public function getDeliveryChargeAttribute()
    // {
    //     $data = OrderDetail::where('order_id',$this->id)->where('user_id',user()->id)->pluck('place_type')->toArray();

    //     if(count($data) > 0){
    //         $type = array_unique($data);
    //         $type = $type[0];
    //         $charge = DeliveryChargeSetting::where('user_id',user()->id)->first();
    //         if($type == 'inside'){
    //             $percantageAmt = $charge->inside_city_charge / 100;
    //             $amt = $this->total * $percantageAmt;
    //         }else{
    //             $percantageAmt = $charge->outside_city_charge / 100;
    //             $amt = $this->total * $percantageAmt;
    //         }
    //         return $amt;
    //     }

    //     return "0";   
        
    // }



}
