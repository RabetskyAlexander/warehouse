<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRates;
use App\Models\Importer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function search(Request $request)
    {
        $data = $this->validate($request,
            [
                'term' => 'required|string|max:100',
            ]
        );
        return $this->productRepository->searchByName($data['term']);
    }

    public function getAnalogByProductId(Request $request)
    {
        $data = $this->validate($request,
            [
                'product_id' => 'required|integer',
            ]
        );
        return $this->productRepository->getAnalogByProductIds([$data['product_id']]);
    }

    public function getAnalogByCodeId(Request $request)
    {
        $data = $this->validate($request,
            [
                'code_id' => 'required|integer',
            ]
        );
        return $this->productRepository->getAnalogByCodeId($data['code_id']);
    }

    public function getAnalogByTypeId(Request $request)
    {
        $data = $this->validate($request,
            [
                'type_id' => 'required|integer',
            ]
        );
        return $this->productRepository->getAnalogByTypeId($data['type_id']);
    }

    public function edit($productId)
    {
//        set_time_limit(0);
//        ProductImages::query()
//            ->whereNull('product_id')
//            ->chunk(500000, function($items){
//                foreach ($items as $item){
//                    $product = Product::query()
//                        ->where('name', $item->DataSupplierArticleNumber)
//                        ->where('brand_id', $item->supplierId)
//                        ->first();
//
//                    if($product){
//                        $item->product_id = $product->id;
//                        $item->save();
//                    }
//                    else{
//                        $item->delete();
//                    }
//                }
//            });
//        die();
        $product = (new ProductRepository())->getById($productId);
        return view('product.edit')->with(['product' => $product, 'importers' => Importer::all()]);
    }

    public function update(Request $request)
    {
        $data = $this->validate($request,
            [
                'id' => 'required|integer',
                'name' => 'required|string|max:255',
                'brand_id' => 'required|integer',
                'type_id' => 'required|integer',
                'count' => 'required|integer',
                'price' => 'required|numeric',
                'importer_id' => 'integer|nullable',
                'date' => 'required|date',
                'description' => 'string|nullable',
                'place' => 'string|nullable',
                'user_description' => 'string|nullable'
            ]
        );


        $product = $this->productRepository->getById($data['id']);

         $this->productRepository->update($product, $data);

        return redirect('/products/edit/' . $product->id);
    }

    public function copy(Request $request)
    {
        $productIdOrigin = $request->get('product_id');
        $productIdCopy = $request->get('product_copy_id');
        if ($productIdCopy && $productIdOrigin) {
            $this->productRepository->copy($productIdOrigin, $productIdCopy);
        }
        return redirect('/products/edit/' . $productIdOrigin);
    }

    public function breakHoseSearch(Request $request)
    {
        $data = $this->validate($request,
            [
                'width' => 'required|numeric',
                'type_1' => 'required|numeric',
                'type_2' => 'required|numeric',
            ]
        );
        return $this->productRepository->breakHoseSearch($data['width'], $data['type_1'], $data['type_2']);
    }

    public function absorberSearch(Request $request)
    {
        $data = $this->validate($request,
            [
                'width' => 'required|numeric',
            ]
        );
        return $this->productRepository->absorberSearch($data['width']);
    }

    public function rollerSearch(Request $request)
    {
        $data = $this->validate($request,
            [
                'width' => 'required|numeric',
                'height' => 'required|numeric',
            ]
        );
        return $this->productRepository->rollerSearch($data['height'], $data['width']);
    }

    public function imageAdd(Request $request)
    {

        if ($request->isMethod('post') && $request->file('file')) {
            $data = $this->validate($request,
                [
                    'product_id' => 'required|integer',
                ]
            );
            $file = $request->file('file');
            $product = Product::query()->findOrFail($data['product_id']);

            $img = new ProductImage();
            $img->src = date('s') . $file->getClientOriginalName();
            $img->product_id = $product->id;
            $upload_folder = '/images/' . $product->brand_id;
            $file->move(public_path() . $upload_folder, $img->src);
            $img->save();
            return redirect('products/edit/' . $product->id);
        }
    }

    public function imageRemove(Request $request)
    {
        $data = $this->validate($request,
            [
                'image_id' => 'required|integer',
            ]
        );

        $image = ProductImage::query()->with(['product'])->findOrFail($data['image_id']);

        unlink(public_path() . '/images/' . $image->product->brand_id . '/' . $image->src);
        return ProductImage::query()
            ->where('id', $data['image_id'])
            ->delete();
    }

    public function codeAdd(Request $request)
    {
        $data = $this->validate($request,
            [
                'product_id' => 'integer',
                'code_id' => 'required|integer',
            ]
        );
        (new ProductRepository())->addCode($data['product_id'], $data['code_id']);
    }

    public function codeRemove(Request $request)
    {
        $data = $this->validate($request,
            [
                'product_id' => 'required|integer',
                'code_id' => 'required|integer',
            ]
        );
        return $this->productRepository->codeRemove($data['product_id'], $data['code_id']);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $this->validate($request,
                [
                    'name' => 'required|string|max:255',
                    'brand_id' => 'required|integer',
                    'type_id' => 'required|integer',
                    'count' => 'required|integer',
                    'price' => 'required|numeric',
                    'importer_id' => 'required|integer',
                    'date' => 'required|date',
                    'description' => 'string|nullable',
                    'place' => 'string|nullable',
                    'user_description' => 'string|nullable'
                ]
            );
            $product = $this->productRepository->update(null, $data);
            return redirect('/products/edit/' . $product->id);
        }
        return view('product.add');
    }
}
