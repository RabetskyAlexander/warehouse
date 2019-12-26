<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 16.03.2018
 * Time: 2:12
 */

namespace App\Repositories;


use App\Models\ProductAttributeType;
use Illuminate\Support\Facades\DB;

class ProductAttributeTypeRepository
{
    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function searchByName(string $name)
    {
        return ProductAttributeType::query()
            ->where('name', 'like', '%' . $name . '%')
            ->distinct()
            ->limit(20)
            ->get();
    }

    /**
     * @param string $name
     * @return ProductAttributeType
     */
    public function add(string $name)
    {
        $model = new ProductAttributeType();
        $model->name = $name;
        $model->save();
        return $model;
    }
}