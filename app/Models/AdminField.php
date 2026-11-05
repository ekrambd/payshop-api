<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminField extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',

        'slider_add',
        'slider_edit',
        'slider_lists',
        'slider_delete',
        'slider_status_update',

        'category_add',
        'category_edit',
        'category_lists',
        'category_delete',
        'category_status_update',

        'subcategory_add',
        'subcategory_edit',
        'subcategory_lists',
        'subcategory_delete',
        'subcategory_status_update',

        'unit_add',
        'unit_edit',
        'unit_lists',
        'unit_delete',
        'unit_status_update',

        'variant_add',
        'vairant_edit',
        'variant_lists',
        'variant_delete',

        'vendor_lists',
        'vendor_product_verify',
        'vendor_product_status_change',
        'vendor_product_lists',
        'vendor_edit_requests',
    ];
}
