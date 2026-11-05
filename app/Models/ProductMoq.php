<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMoq extends Model
{
    use HasFactory;

    protected $table = 'product_moqs';

    protected $fillable = [
        'product_id',
        'from_qty',
        'to_qty',
        'price',
    ];

    protected $casts = [
        'from_qty' => 'integer',
        'price'    => 'float',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
