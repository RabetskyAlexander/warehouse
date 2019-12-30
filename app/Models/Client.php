<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    public $timestamps = false;

    public function cars(){
        return $this->hasMany(ClientCar::class, 'client_id', 'id');
    }
}
