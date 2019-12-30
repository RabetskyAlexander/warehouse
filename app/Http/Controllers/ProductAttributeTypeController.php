<?php

namespace App\Http\Controllers;

use App\Models\ProductAttributeType;
use App\Repositories\ProductAttributeTypeRepository;
use Illuminate\Http\Request;

class ProductAttributeTypeController extends Controller
{
    private $productAttributeTypeRepository;

    public function __construct(ProductAttributeTypeRepository $productAttributeTypeRepository)
    {
        $this->productAttributeTypeRepository = $productAttributeTypeRepository;
    }

    public function search(Request $request)
    {
        $data = $this->validate($request,
            [
                'term' => 'required|string|max:255',
            ]
        );
        return $this->productAttributeTypeRepository->searchByName($data['term']);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $this->validate($request,
                [
                    'name' => 'required|string|max:255|unique:product_attribute_types,name',
                ]
            );
            $productAttributeType = $this->productAttributeTypeRepository->add($data['name']);
            return redirect('/product-attribute-types/view/' . $productAttributeType->id);
        } else {
            return view('product-attribute-type.add');
        }
    }

    public function view($id)
    {
        $productAttributeType = ProductAttributeType::query()->find($id);
        return view('product-attribute-type.view')->with(['productAttributeType' => $productAttributeType]);
    }
}
