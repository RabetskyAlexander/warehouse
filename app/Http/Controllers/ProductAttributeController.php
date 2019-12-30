<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Repositories\ProductAttributeRepository;
use App\Repositories\ProductAttributeTypeRepository;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    /** @var  ProductAttributeRepository */
    private $productAttributeRepository;

    /** @var  ProductAttributeTypeRepository */
    private $productAttributeTypeRepository;

    public function __construct(
            ProductAttributeRepository $productAttributeRepository,
            ProductAttributeTypeRepository $productAttributeTypeRepository
        )
    {
        $this->productAttributeRepository = $productAttributeRepository;
        $this->productAttributeTypeRepository = $productAttributeTypeRepository;
    }

    public function remove(Request $request){
        $messages = [];
        $data = $this->validate($request,
            [
                'id' => 'required|integer',
            ],
            $messages
        );
        return $this->productAttributeRepository->remove($data['id']);
    }

    public function search(Request $request)
    {
        $message = [];
        $data = $this->validate($request,
            [
                'term' => 'required|string|max:255',
            ],
            $message
        );
        return $this->productAttributeTypeRepository->searchByName($data['term']);
    }

    public function add(Request $request)
    {
            $message = [];
            $data = $this->validate($request,
                [
                    'value' => 'required|string|max:255',
                    'product_id' => 'required|integer',
                    'product_attribute_type_id' => 'required|integer',
                ],
                $message
            );
            return $this->productAttributeRepository->add(
                $data['product_id'],
                $data['product_attribute_type_id'],
                $data['value']
            );
    }
}
