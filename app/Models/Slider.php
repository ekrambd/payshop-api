<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $appends = ['slider_image'];

    protected $fillable = [
        'user_id',
        'image',
        'status',
    ];

    public function getSliderImageAttribute()
    {
        $path = env('FILE_PATH_URL')."/uploads/sliders/".$this->image;
        return $path;
    }

}
