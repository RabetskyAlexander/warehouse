<?php

namespace App\Repositories;

use App\Models\Code;
use App\Models\CodeProduct;
use App\Utils\Utils;
use Illuminate\Support\Facades\DB;

class CodeRepository
{
    public function add(string $name, int $manufactureId)
    {
        $code =  new Code();
        $code->setRawAttributes(
            [
                'name' => $name,
                'name_search' => Utils::stringFormat($name),
                'manufacture_id' => $manufactureId,
            ]
        );
        $code->saveOrFail();
        return $code;
    }


    public function searchByName(string $name)
    {
        $name = Utils::stringFormat($name);
        return DB::table('codes')
            ->join('manufacturers', 'codes.manufacture_id', 'manufacturers.id')
            ->where('codes.name_search', 'LIKE', $name . '%')
            ->select('codes.name', 'manufacturers.description as brandName', 'codes.id', 'codes.id as is_code')
            ->limit(10)
            ->distinct()
            ->get();
    }
}