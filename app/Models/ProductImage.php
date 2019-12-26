<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';

    public $timestamps = false;

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
