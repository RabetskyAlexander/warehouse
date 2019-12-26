<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCross extends Model
{
    protected $table = 'product_crosses';

    public $timestamps = false;

    public function product(){
        return $this->hasOne(Product::class, 'id', 'cross_id');
    }
}
