<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_types';

    public $timestamps = false;

    public function parent(){
        return $this->hasOne(self::class, 'id', 'parent_id');
    }
}
