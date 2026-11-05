<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SteadfastOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'vendor_id',
        'user_id',
        'invoice',
        'consignment_id',
        'tracking_code',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
        'cod_amount',
        'note',
        'status',
        'delivery_status',
        'response_data',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
