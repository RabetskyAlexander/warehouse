<?php

namespace App\Http\Controllers;

use App\Models\Manufacturers;
use App\Repositories\ManufactureRepository;
use Illuminate\Http\Request;

class ManufactureController extends Controller
{
    /** @var  ManufactureRepository */
    private $manufactureRepository;

    public function __construct(ManufactureRepository $manufactureRepository)
    {
        $this->manufactureRepository = $manufactureRepository;
    }

    public function index()
    {
        return view('manufacture.index')->with(['brands' => $this->manufactureRepository->getForCar()]);
    }

    public function updateStatus(Request $request)
    {
        $data = $this->validate($request,
            [
                'id' => 'required|integer',
                'is_show' => 'required|integer'
            ]
        );
        $this->manufactureRepository->updateStatus($data['id'], $data['is_show']);
    }

    public function search(Request $request)
    {
        $data = $this->validate($request,
            [
                'name' => 'required|string|max:255',
            ]
        );
       return $this->manufactureRepository->searchByName($data['name']);
    }
}
