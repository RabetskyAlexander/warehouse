<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use App\Repositories\ProductTypeRepository;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    /** @var  ProductTypeRepository */
    private $productTypeRepository;

    public function __construct(ProductTypeRepository $productTypeRepository)
    {
        $this->productTypeRepository = $productTypeRepository;
    }

    public function search(Request $request)
    {
        $data = $this->validate($request, ['term' => 'required|string|max:255']);
        return $this->productTypeRepository->searchByName($data['term']);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $this->validate(
                $request,
                [
                    'name' => 'required|string|max:255|unique:product_types,name',
                    'parent_id' => 'integer',
                ]
            );
            $productType = $this->productTypeRepository->add($data['name'], $data['parent_id']);
            return redirect('/product-types/view/' . $productType->id);
        } else {
            return view('product-type.add');
        }
    }

    public function view($id)
    {
        return view('product-type.view')->with(['productType' => ProductType::query()->findOrFail($id)]);
    }
}
