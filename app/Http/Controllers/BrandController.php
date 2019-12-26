<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function search(Request $request)
    {
        $data = $this->validate($request,
            [
                'term' => 'required|string|max:255',
            ]
        );
        return $this->brandRepository->searchByName($data['term']);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $this->validate($request,
                [
                    'name' => 'required|string|max:255|unique:brands,name',
                ]
            );
            $brand = $this->brandRepository->add($data['name']);
            return redirect('/brands/view/' . $brand->id);
        } else {
            return view('brand.add');
        }
    }

    public function view($id)
    {
        $brand = Brand::query()->find($id);
        return view('brand.view')->with(['brand' => $brand]);
    }

    public function index()
    {
        return view('brand.index')->with(['brands' => Brand::all()]);
    }

    public function updateStatus(Request $request)
    {
        $data = $this->validate($request,
            [
                'id' => 'required|integer',
                'is_show' => 'required|integer',
            ]
        );
        $this->brandRepository->updateStatus($data['id'], $data['is_show']);
    }
}
