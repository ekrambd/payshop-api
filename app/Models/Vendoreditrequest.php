<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendoreditrequest extends Model
{
    use HasFactory;

    protected $table = 'vendoreditrequests';

    protected $fillable = [
        'user_id',
        'vendor_id',
        'field_name',
        'old_value',
        'new_value',
        'old_file',
        'new_file',
        'status',
        'admin_note',
        'approved_by',
        'approved_at',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function vendor()
    {
    	return $this->belongsTo(Vendor::class);
    }
}
