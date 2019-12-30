<?php

namespace App\Repositories;

use App\Models\ProductType;
use Illuminate\Support\Facades\DB;

class ProductTypeRepository
{

    public function add(string $name, int $parentId)
    {
        $productType = new ProductType();
        $productType->parent_id = $parentId;
        $productType->name = $name;
        $productType->save();
        return $productType;
    }

    public function searchByName ($name ){
        return ProductType::query()
            ->with(['parent'])
            ->where('product_types.name', 'LIKE', '%' . $name.'%')
            ->limit(10)
            ->distinct()
            ->get();
    }

    public function searchByProductId($id){
        return DB::table('product_types')
            ->join('product_type', 'product_type.product_type_id', 'product_types.id' )
            ->where('product_type.product_id', $id)
            ->select(
                'product_types.name',
                'product_types.id'
            )
            ->distinct()
            ->get();
    }



    public function copyBuProductId($product_id, $product_copy_id){
        $types = DB::table('product_types')
            ->where('product_types.product_id', $product_copy_id)
            ->whereNotIn('product_types.product_type_id',
                DB::table('product_types')
                    ->where('product_types.product_id', $product_id)
                    ->select('product_types.product_type_id as id')
            )
            ->select('product_types.product_type_id as id')
            ->get();

        foreach ( $types as $p)
            DB::table('product_types')
                ->insert(
                    [
                        'product_id' => $product_id,
                        'product_type_id' => $p->id
                    ]);
    }
}