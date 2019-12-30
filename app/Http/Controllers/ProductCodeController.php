<?php

namespace App\Http\Controllers;

use App\Repositories\CodeRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductCodeController extends Controller
{
    /** @var  CodeRepository */
    private $codeRepository;
    public function __construct(CodeRepository $codeRepository)
    {
        $this->codeRepository = $codeRepository;
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
        return $this->codeRepository->searchByName($data['term']);
    }

    public function remove(Request $request){
        $message = [];
        $data = $this->validate($request,
            [
                'product_id' => 'required|integer',
                'code_id' => 'required|integer',
            ],
            $message
        );
        return $this->codeRepository->remove($data['product_id'], $data['code_id']);
    }

    public function add(Request $request){
        $message = [];
        $data = $this->validate($request,
            [
                'product_id' => 'required|integer',
                'code_id' => 'required|integer',
            ],
            $message
        );
        return $this->codeRepository->add($data['product_id'], $data['code_id']);
    }

    public function createView(){
        return view('product-code.add');
    }

    public function create(Request $request){
        $message = [];
        $data = $this->validate($request,
            [
                'code' => 'required|string|max:255',
                'manufacture_id' => 'required|integer',
            ],
            $message
        );
        return $this->codeRepository->add($data['product_id'], $data['code_id']);
    }
}
