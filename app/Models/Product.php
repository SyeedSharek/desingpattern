<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'description', 'quantity','discount'];

    protected $appends = ['image_urls'];


    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getImageUrlsAttribute()
    {
        return $this->productImages->map(function ($image) {
            return asset('storage/' . $image->image_path);
        })->toArray();
    }
}
