<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $table = 'product_attributes';

    public $timestamps = false;

    public function type()
    {
        return $this->hasOne(ProductAttributeType::class, 'id', 'product_attribute_type_id');
    }
}
