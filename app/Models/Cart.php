<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DeliveryChargeSetting;
use Session;

class Cart extends Model
{
    use HasFactory;

    //protected $appends = ['delivery_charge'];

    protected $fillable = [
	    'cart_session_id',
	    'product_id',
	    'variant_id',
        'vendor_id',
	    'product_variant_id',
	    'cart_price',
	    'cart_qty',
	    'currency',
	    'unit_total',
	];

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function variant()
    {
    	return $this->belongsTo(Variant::class);
    }

    public function productVariant()
    {
    	return $this->belongsTo(ProductVariant::class);
    }

	public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // public function getDeliveryChargeAttribute()
    // {
    //     $charge = DeliveryChargeSetting::where('user_id', user()->id)->first();
    //     $sum = Self::selectRaw('MAX(unit_total) as total')
    //         ->where('cart_session_id', Session::get('cart_session_id'))
    //         ->groupBy('product_id')
    //         ->pluck('total')
    //         ->sum();
    //     return ($sum * $charge->inside_city_charge) / 100; 
    // } 
}
