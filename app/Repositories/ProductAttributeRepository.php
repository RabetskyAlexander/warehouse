<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.03.2018
 * Time: 19:37
 */

namespace App\Repositories;


use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;

class ProductAttributeRepository
{
    public function remove(int $attribute_id)
    {
        return ProductAttribute::query()
            ->where('id', $attribute_id)
            ->delete();
    }

    public function add(int $productId, int $productAttributeTypeId, string $value)
    {
        return ProductAttribute::query()
            ->insertOrIgnore(
                [
                    'product_id' => $productId,
                    'product_attribute_type_id' => $productAttributeTypeId,
                    'display_value' => $value,
                    'value' => floatval($value)
                ]
            );
    }
}