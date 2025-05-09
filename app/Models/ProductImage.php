<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Full image URL accessor
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }




}
