<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',

        'shop_name',

        'nid_number',

        'nid_front',

        'nid_back',

        'selfie_photo',

        'trade_license_no',
        
        'trade_file',

        'tin_no',

        'tin_file',

        'bin_no',

        'bin_file',

        'bank_name',

        'branch_name',

        'account_name',

        'account_number',

        'cancelled_cheque',

        'pickup_address',

        'return_address',

        'district',

        'routing_number',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vendoreditrequests()
    {
        return $this->hasMany(Vendoreditrequest::class);
    }
}
