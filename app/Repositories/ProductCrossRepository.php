<?php

namespace App\Repositories;

use App\Models\ProductCross;

class ProductCrossRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function remove(int $product_id, int $code_id){
        return ProductCross::query()
            ->where('product_id', $product_id)
            ->where('cross_id', $code_id)
            ->delete();
    }

    public function add($productId, $crossId)
    {
        $productCrossIds = ProductCross::query()
            ->where('product_id', $crossId)
            ->distinct()
            ->pluck('cross_id');

        $productCrossIds = $productCrossIds->push($crossId);

        foreach ($productCrossIds as $productCrossId){

            ProductCross::query()->insertOrIgnore(
                [
                    'product_id' => $productCrossId,
                    'cross_id' => $productId
                ]
            );

            ProductCross::query()->insertOrIgnore(
                [
                    'product_id' => $productId,
                    'cross_id' => $productCrossId
                ]
            );
        }
        return true;
    }
}