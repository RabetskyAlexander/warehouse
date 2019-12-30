<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $table = 'codes';

    public $timestamps = false;

    public function products(){
        $this->belongsToMany(Product::class);
    }

    public function manufacture(){
        return $this->hasOne(Manufacturers::class, 'id', 'manufacture_id');
    }
}
