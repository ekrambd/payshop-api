<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $appends = ['category_image'];

    protected $fillable = [
        'user_id',
        'category_name',
        'image',
        'slug',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function getCategoryImageAttribute()
    {
        $path = env('FILE_PATH_URL')."/uploads/categories/".$this->image;
        return $path;
    }
}
