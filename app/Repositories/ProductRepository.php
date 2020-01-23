<?php

namespace App\Repositories;

use App\Models\Code;
use App\Models\CodeProduct;
use App\Models\ExchangeRates;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCode;
use App\Models\ProductCross;
use App\Models\ProductOe;
use App\Models\ProductPart;
use App\Models\ProductType;
use App\Utils\Utils;
use Hamcrest\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function searchByName(string $name)
    {
        $name = Utils::stringFormat($name);

        $result = DB::table('products')
            ->leftJoin('product_types', 'product_types.id', '=', 'products.type_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('products.name_search', 'like', $name . '%')
            ->select(
                'products.id',
                'products.name',
                'brands.name as brandName',
                'product_types.name as typeName'
            )
            ->limit(15)
            ->get();

        return $result;
    }

    public function addCode($productId, $codeId)
    {
        return CodeProduct::query()->insertOrIgnore(
            [
                'product_id' => $productId,
                'code_id' => $codeId
            ]
        );
    }

    public function getAnalogByCodeId(int $codeId)
    {

        $productIds = CodeProduct::query()
            ->where('code_id', $codeId)
            ->pluck('product_id');

        $productCrossIds = ProductCross::query()
            ->whereIn('product_id', $productIds)
            ->distinct()
            ->pluck('cross_id');

        $productIds = $productIds->merge($productCrossIds);

        $oeIds = CodeProduct::query()
            ->whereIn('product_id', $productIds)
            ->distinct()
            ->pluck('code_id');

        $productIdsFromOe = CodeProduct::query()
            ->whereIn('code_id', $oeIds)
            ->distinct()
            ->pluck('product_id');

        $productIds = $productIds->merge($productIdsFromOe);

        $productPartIds = ProductPart::query()
            ->whereIn('product_part_id', $productIds)
            ->pluck('product_id');

        $productIds = $productIds->merge($productPartIds);
        $products = $this->sortForTable($productIds);
        return $products;
    }

    public function getAnalogByTypeId(int $typeId)
    {
        $productIds = Product::query()
            ->where('type_id', $typeId)
            ->limit(1000)
            ->pluck('id');


        $products = $this->sortForTable($productIds);
        return $products;
    }

    public function getAnalogByProductIds(array $ids, $strictType = true, $onlyCross = false)
    {
        $productTypeId = null;
        if (count($ids) === 1 && $strictType) {
            $productTypeId = Product::query()->whereIn('id', $ids)->first()->type_id;
        }

        $productIds = ProductCross::query()
            ->whereIn('product_id', $ids)
            ->distinct()
            ->pluck('cross_id');

        $productIds = $productIds->merge($ids);

        if ($onlyCross == false) {
            $query = CodeProduct::query()
                ->whereIn('code_product.product_id', $productIds);

            if ($productTypeId) {
                $query->join('products', 'products.id', '=', 'code_product.product_id')
                    ->where('products.type_id', $productTypeId);
            }
            $oeIds = $query->pluck('code_product.code_id');
            $productIdsFromOe = CodeProduct::query()
                ->whereIn('code_id', $oeIds)
                ->pluck('product_id');

            $productIds = $productIds->merge($productIdsFromOe);
        }

        $productIds = $productIds->merge($ids);

        if (true) {
            $productPartIds = ProductPart::query()
                ->whereIn('product_part_id', $productIds->slice(0, 500))
                ->pluck('product_id');
            $productIds = $productIds->merge($productPartIds);
        }
        $products = $this->sortForTable($productIds);
        return $products;
    }

    public function sortForTable($productIds)
    {
        $productIds = $productIds->unique()->values()->all();
        $products = DB::table('products')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->leftJoin('product_types', 'product_types.id', 'products.type_id')
            ->leftJoin('importers', 'importers.id', '=', 'products.importer_id')
            ->select(
                'products.id',
                'products.brand_id',
                'products.name',
                'products.description',
                'brands.name as brandName',
                'product_types.name as typeName',
                'products.date as datePurchase',
                'products.price',
                'products.count',
                'products.place',
                'products.user_description as descriptionClient',
                'importers.name as importerName',
                DB::raw("(SELECT src FROM product_images WHERE product_id = products.id limit 1) as image")

            )
            ->whereIn('products.id', collect($productIds)->slice(0, 500))
            ->where('brands.is_show', true)
            ->orderBy('count', 'desc')
            ->get();

        $products = $products->sortBy('price')
            ->sortByDesc('count')
            ->values()
            ->all();

        $money = ExchangeRates::query()
            ->first();

        foreach ($products as $product) {

            if (Auth::user() === null) {
                $product->importerName = null;
            }

            if (empty($product->image)) {
                $product->image = '/images/no_photo.jpg';
            } else {
                $product->image = '/images/' . $product->brand_id . '/' . $product->image;
            }

            if (isset($product->price)) {
                $product->price = round($product->price * $money->euro, 1, PHP_ROUND_HALF_ODD);
                if (Auth::user() === null) {
                    $product->importerName = null;

//                    if ($product->price <= 10) {
//                        $product->price = $product->price + 3;
//                    } elseif ($product->price <= 20) {
//                        $product->price = $product->price + 4;
//                    } elseif ($product->price <= 30)
//                        $product->price = $product->price + 5;
//                    elseif ($product->price <= 40)
//                        $product->price = $product->price + 6;
//                    elseif ($product->price <= 50)
//                        $product->price = $product->price + 7;
//                    else
//                        $product->price = $product->price + 11;

                }
            }
        }
        return $products;
    }

    public function getById($productId)
    {
        return Product::query()
            ->with(
                [
                    'brand',
                    'type',
                    'crosses',
                    'crosses.product',
                    'crosses.product.brand',
                    'crosses.product.type',
                    'codes',
                    'codes.manufacture',
                    'attributes',
                    'attributes.type',
                    'images'
                ]
            )
            ->findOrFail($productId);
    }

    public function update($product, $data)
    {
        if ($product === null) {
            $product = new Product();
        }
        if (array_key_exists('price', $data)) {
            $money = ExchangeRates::query()->first();
            $data['price'] = floatval($data['price']) / $money->euro;
        }
        $data['name_search'] = Utils::stringFormat($data['name']);
        $product->setRawAttributes($data);
        $product->save();
        return $product;
    }

    public function copyCodes($productOrigin, $productCopy)
    {

    }

    public function copy($productOriginId, $productCopyId)
    {

        try {
            $productOrigin = $this->getById($productOriginId);
            $productCopy = $this->getById($productCopyId);

            $productCrossRepository = new ProductCrossRepository();
            foreach ($productCopy->crosses as $cross) {
                $productCrossRepository->add($productOrigin->id, $cross->cross_id);
            }

            foreach ($productCopy->codes as $code) {
                $this->addCode($productOrigin->id, $code->id);
            }

            $productAttributeRepository = new ProductAttributeRepository();
            foreach ($productCopy->attributes as $attribute) {
                $productAttributeRepository->add(
                    $productOrigin->id,
                    $attribute->product_attribute_type_id,
                    $attribute->display_value
                );
            }

        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function breakHoseSearch($width, $type1, $type2)
    {
        $types =
            [
                1 => [
                    'diameter' => 'M10x1',
                    'type' => 'Внешняя резьба'
                ],
                2 => [
                    'diameter' => 'M10x1',
                    'type' => 'Внутренняя резьба'
                ]
            ];

        $products = Product::query()
            ->with(['attributes'])
            ->join('product_attributes as pa', 'pa.product_id', '=', 'products.id')
            ->where('pa.product_attribute_type_id', '=', 203)
            ->where('pa.value', '>=', $width - 5)
            ->where('pa.value', '<=', $width + 10)
            ->where('products.type_id', 100035)
            ->where('products.brand_id', 161)
            ->select('products.id')
            ->get();

        $result = [];
        foreach ($products as $product) {

            if ($product->attributes()->count() >= 3) {

                $attributeDiameter = collect($product->attributes->whereIn('product_attribute_type_id', [991, 992])->all());
                $attributeTypes = collect($product->attributes->where('product_attribute_type_id', 571)->all());

                if ($type1 == $type2) {

                    $isAvailableType = false;
                    if ($attributeTypes->count() === 1) {
                        $availableTypes = $attributeTypes->where('display_value', $types[$type1]['type'])->count();
                        if ($attributeTypes) {
                            $isAvailableType = true;
                        }
                    } elseif ($attributeTypes->count() === 2) {
                        $availableTypes = $attributeTypes->where('display_value', $types[$type1]['type'])->all();
                        if ($attributeTypes->count() === 2) {
                            $isAvailableType = true;
                        }
                    }

                    if ($isAvailableType) {
                        $isAvailableDiameter = false;
                        if ($attributeDiameter->count() === 1) {
                            $availableDiameter = $attributeDiameter->where('display_value', $types[$type1]['diameter'])->count();
                            if ($availableDiameter) {
                                $isAvailableDiameter = true;
                            }
                        } elseif ($attributeDiameter->count() === 2) {
                            $availableDiameter = $attributeDiameter->where('display_value', $types[$type1]['diameter'])->count();
                            if ($availableDiameter === 2) {
                                $isAvailableDiameter = true;
                            }
                        }

                        if ($isAvailableType && $isAvailableDiameter) {
                            $result[] = $product->id;
                        }
                    }
                }

                if ($type1 != $type2) {

                    $isAvailableType = false;
                    if ($attributeTypes->count() === 2) {
                        $availableType1 = $attributeTypes->where('display_value', $types[$type1]['type'])->count();
                        $availableType2 = $attributeTypes->where('display_value', $types[$type2]['type'])->count();

                        if ($availableType1 && $availableType2) {
                            $isAvailableType = true;
                        }
                    }

                    if ($isAvailableType) {
                        $isAvailableDiameter = false;
                        if ($attributeDiameter->count() === 2) {
                            $availableDiameter1 = $attributeDiameter->whereIn('display_value', $types[$type1]['diameter'])->count();
                            $availableDiameter2 = $attributeDiameter->whereIn('display_value', $types[$type2]['diameter'])->count();

                            if ($availableDiameter1 && $availableDiameter2) {
                                $isAvailableDiameter = true;
                            }
                        }

                        if ($isAvailableType && $isAvailableDiameter) {
                            $result[] = $product->id;
                        }
                    }
                }
            }
        }
        return $this->getAnalogByProductIds($result);
    }

    public
    function rollerSearch($height, $width)
    {
        $products = Product::query()
            ->with(
                [
                    'attributes' => function ($query) {
                        $query->whereIn('product_attribute_type_id', [497, 206]);
                    }
                ]
            )
            ->whereIn('type_id', [100435, 100434, 100407])
            ->where('brand_id', 23)
            ->get();

        $result = [];

        foreach ($products as $product) {
            if ($product->attributes->count() > 1) {
                $attributeHeight = $product->attributes->where('product_attribute_type_id', 497)->first();
                $attributeWidth = $product->attributes->where('product_attribute_type_id', 206)->first();

                if (
                    $attributeHeight
                    && $attributeWidth
                    && $attributeHeight->value <= $height + 3
                    && $attributeHeight->value >= $height - 3
                    && $attributeWidth->value <= $width + 3
                    && $attributeWidth->value >= $width - 3
                ) {
                    $result[] = $product->id;
                }
            }
        }
        return $this->getAnalogByProductIds($result, false);
    }

    public
    function absorberSearch(int $width)
    {
        $products = Product::query()
            ->with(
                [
                    'attributes' => function ($query) use ($width) {
                        $query->where('product_attribute_type_id', 431)
                            ->where('value', '>=', $width - 10)
                            ->where('value', '<=', $width + 10);
                    }
                ]
            )
            ->where('type_id', 100826)
            ->where('brand_id', 4558)
            ->get();

        $result = [];
        foreach ($products as $product) {
            if ($product->attributes->count() > 0) {
                $result[] = $product->id;
            }
        }
        return $this->getAnalogByProductIds($result);
    }

    public
    function codeRemove($productId, $codeId)
    {
        return CodeProduct::query()
            ->where('product_id', $productId)
            ->where('code_id', $codeId)
            ->delete();
    }
}
