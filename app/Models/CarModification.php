<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarModification extends Model
{
    protected $table = 'passanger_cars';

    public function model()
    {
        return $this->hasOne(CarModel::class, 'id', 'passanger_car_id');
    }
}
