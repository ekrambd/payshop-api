<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryChargeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
	    'user_id',
	    'inside_city_charge',
	    'outside_city_charge',
	    'per_weight_charge',
	];

}
