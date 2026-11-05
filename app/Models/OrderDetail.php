<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'user_id',
        'product_variant_id',
        'payment_method_id',
        'purchase_price',
        'purchase_discount',
        'vendor_price',
        'current_symbol',
        'vendor_symbol',
        'qty',
        'place_type',
        'delivery_charge',
        'status'
    ];

    public function getVendorPriceAttribute($value)
    {
        if ($value !== null && $value > 0) {
            return (float) $value;
        }
        $vendor = Vendor::where('user_id', $this->user_id)->first();
        $vendorRate = getVendorCurrencyRate($vendor ? $vendor->id : null);
        if ($this->product && $this->product->product_price > 0) {
            $discountFactor = 1 - (($this->purchase_discount ?? 0) / 100);
            return (float) round($this->product->product_price * $discountFactor * $vendorRate, 2);
        }
        return (float) $this->purchase_price;
    }

    public function getVendorSymbolAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }
        $vendor = Vendor::where('user_id', $this->user_id)->first();
        return getVendorCurrencySymbol($vendor ? $vendor->id : null);
    }

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

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
}
