<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['product_image','discount_price','convert_price','current_symbol','original_price','short_description'];

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'unit_id',
        'product_name',
        'slug',
        'product_price',
        'product_discount',
        'stock_qty',
        'description',
        'featured_image',
        'status',
        'admin_verify',
    ];

    // protected $casts = [
    //     'product_price' => 'decimal:2',
    //     'product_discount' => 'decimal:2',
    //     'stock_qty' => 'decimal:2',
    // ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function productdeliverycharge()
    {
        return $this->hasOne(Productdeliverycharge::class);
    }

    public function getProductImageAttribute()
    {
        $path = env('FILE_PATH_URL')."/".$this->featured_image;
        return $path;
    }

    public function getConvertPriceAttribute()
    {
        return round($this->product_price * getUserCurrencyRate(), 2);
    }

    public function getCurrentSymbolAttribute()
    {   
        return getUserCurrencySymbol();
    }

    public function getShortDescriptionAttribute()
    {   
        $html = $this->description;
        $shortDescription = \Illuminate\Support\Str::limit(
            preg_replace('/\s+/', ' ', strip_tags($html ?? '')),
            180
        );

        return $shortDescription;
    }

    public function getOriginalPriceAttribute()
    {
        $price = $this->product_price * getUserCurrencyRate();
        return number_format($price, 2, '.', '');
    }
    
    public function getCalPriceAttribute()
    {
        return $this->product_price * parentCurrencyRate();
    }

    public function getDiscountPriceAttribute()
    {   
        $userRate = getUserCurrencyRate();
        if ($this->product_discount > 0) {
            $finalAmount = $this->product_price * (1 - ($this->product_discount / 100));
        } else {
            $finalAmount = $this->product_price;
        }

        return round($finalAmount * $userRate, 2);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function whishlists()
    {
        return $this->hasMany(Whishlist::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    public function moqs()
    {
        return $this->hasMany(ProductMoq::class, 'product_id')->orderBy('from_qty', 'asc');
    }

    public function getMoqTiersAttribute()
    {
        $tiers = $this->moqs;
        if ($tiers && $tiers->count() > 0) {
            return $tiers;
        }

        $legacy = collect();
        if (!empty($this->moq_one_from) && !empty($this->moq_one_to) && $this->moq_one_price !== null) {
            $legacy->push((object)[
                'from_qty' => (int)$this->moq_one_from,
                'to_qty'   => (string)$this->moq_one_to,
                'price'    => (float)$this->moq_one_price,
            ]);
        }
        if (!empty($this->moq_two_from) && !empty($this->moq_two_to) && $this->moq_two_price !== null) {
            $legacy->push((object)[
                'from_qty' => (int)$this->moq_two_from,
                'to_qty'   => (string)$this->moq_two_to,
                'price'    => (float)$this->moq_two_price,
            ]);
        }
        if (!empty($this->moq_three_from) && !empty($this->moq_three_to) && $this->moq_three_price !== null) {
            $legacy->push((object)[
                'from_qty' => (int)$this->moq_three_from,
                'to_qty'   => (string)$this->moq_three_to,
                'price'    => (float)$this->moq_three_price,
            ]);
        }
        return $legacy;
    }

    public function calculatePriceForQty($qty)
    {
        $qty = (int) $qty;
        $tiers = $this->moq_tiers;
        if ($tiers && $tiers->count() > 0) {
            foreach ($tiers as $tier) {
                $from = (int) $tier->from_qty;
                $to = $tier->to_qty;
                if ($qty >= $from && (strtolower((string)$to) === 'unlimited' || $qty <= (int)$to)) {
                    $vendorId = optional(optional($this->user)->vendor)->id;
                    if ($vendorId && function_exists('moqPrice')) {
                        return (float) str_replace(',', '', moqPrice($this->main_product_price ?? $this->product_price, $tier->price, $vendorId));
                    }
                    return (float) $tier->price;
                }
            }
        }

        $base = ($this->product_discount > 0 && isset($this->discount_price)) ? $this->discount_price : ($this->original_price ?? $this->product_price);
        return (float) str_replace(',', '', (string)$base);
    }
}
