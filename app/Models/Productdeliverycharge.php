<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productdeliverycharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'vendor_id',
        'inside_base_charge',
        'outside_base_charge',
        'per_weight_charge',
        'product_weight',
    ];

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }
}
