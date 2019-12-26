<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientCar;
use App\Models\ClientCarProduct;
use App\Repositories\ClientCarRepository;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClientCarController extends Controller
{
    /** @var  ClientCarRepository */
    private $clientCarRepository;

    public function __construct(ClientCarRepository $clientCarRepository)
    {
        $this->clientCarRepository = $clientCarRepository;
    }

    public function update(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $car = $this->clientCarRepository->getById($data['id']);
        $this->clientCarRepository->update($car, $data);
        return redirect('/client-cars/view/' . $car->id);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $this->validate($request,
                [
                    'passanger_car_id' => 'required|integer',
                    'client_id' => 'required|integer',
                ]
            );
            $clientCar = $this->clientCarRepository->update(null, $data);
            return redirect('/client-cars/view/' . $clientCar->id);
        }
        elseif ($request->isMethod('get'))
        {
            $data = $this->validate($request,
                [
                    'client_id' => 'required|integer'
                ]
            );
            return view('client-car.add')->with($data);
        }
    }

    public function view($id)
    {
        $car = $this->clientCarRepository->getById($id);
        return view('client-car.view')->with(['car' => $car]);
    }

    public function select($id){
        Session::put('car_id',$id);
        return redirect('/');
    }

    public function productAdd(Request $request)
    {
        $data = $this->validate($request,
            [
                'product_id' => 'required|integer',
                'client_car_id' => 'required|integer'
            ]
        );
        ClientCarProduct::query()
            ->insertOrIgnore($data);
    }
}
