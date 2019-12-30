<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository
{
    public function searchByName($name)
    {
        return Brand::query()
            ->where('name', 'LIKE', '%' . $name . '%')
            ->limit(10)
            ->distinct()
            ->get();
    }

    public function add($name)
    {
        $brand = new Brand();
        $brand->name = $name;
        $brand->save();
        return $brand;
    }

    public function updateStatus(int $brandId, bool $isShow)
    {
        return Brand::query()
            ->where('id', $brandId)
            ->update(['is_show' => $isShow]);
    }
}