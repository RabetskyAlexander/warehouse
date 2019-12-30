<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientCar extends Model
{
    protected $table = 'client_cars';

    public $timestamps = false;

    public function modification()
    {
        return $this->hasOne(CarModification::class, 'id', 'passanger_car_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
}
