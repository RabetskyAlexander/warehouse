<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function type()
    {
        return $this->hasOne(ProductType::class, 'id', 'type_id');
    }

    public function crosses()
    {
        return $this->hasMany(ProductCross::class, 'product_id', 'id');
    }

    public function codes()
    {
        return $this->belongsToMany(Code::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function attributes()
    {
       return $this->hasMany(ProductAttribute::class, 'product_id', 'id');
    }
}
