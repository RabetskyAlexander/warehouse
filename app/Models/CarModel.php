<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    protected $table = 'models';

    public function manufacturer(){
        return $this->hasOne(Manufacturers::class, 'manufacturer_id', 'id');
    }
}
