<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ImporterRepository
{
    public function getAll ( ){
        return DB::table('importers')
            ->get()
            ->toJson();
    }
}