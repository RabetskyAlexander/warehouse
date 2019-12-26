<?php

namespace App\Http\Controllers;

use App\Models\ProductCross;
use App\Repositories\ProductCrossRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class CrossController extends Controller
{
    /** @var ProductRepository */
    private $productRepository;

    /** @var  ProductCrossRepository */
    private $productCrossRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductCrossRepository $productCrossRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->productCrossRepository = $productCrossRepository;
    }

    public function remove(Request $request)
    {
        $message = [];
        $data = $this->validate($request,
            [
                'product_id' => 'required|integer',
                'cross_id' => 'required|integer',
            ],
            $message
        );
        $this->productCrossRepository->remove($data['product_id'], $data['cross_id']);
    }

    public function add(Request $request)
    {
        $message = [];
        $data = $this->validate($request,
            [
                'product_id' => 'required|integer',
                'cross_id' => 'required|integer',
            ],
            $message
        );
        $this->productCrossRepository->add($data['product_id'], $data['cross_id']);
    }
}
