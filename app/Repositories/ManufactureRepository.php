<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 14.03.2018
 * Time: 23:57
 */

namespace App\Repositories;


use App\Models\Manufacturers;
use Illuminate\Support\Facades\DB;

class ManufactureRepository
{
    public function searchByName (string $name){
        return Manufacturers::query()
            ->where('description','like', $name . '%')
            ->select('id', 'manufacturers.description as name')
            ->limit(10)
            ->distinct()
            ->get();
    }

    public function getForCar(){
        return Manufacturers::query()
            ->where('canbedisplayed', 'True')
            ->orderBy('fulldescription','asc')
            ->get();
    }

    public function updateStatus(int $id, bool $isShow){
        Manufacturers::query()
            ->where('id', $id)
            ->update(['is_show' => $isShow]);
    }
}