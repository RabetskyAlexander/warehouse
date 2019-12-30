<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    /** @var  ClientRepository */
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function index()
    {
        return view('client.index')->with(['clients' => Client::all()]);
    }

    public function view($id)
    {
        $client =  $this->clientRepository->getById($id);
        Session::put('client_id', $client->id);
        return view('client.view')->with(['client' => $client]);
    }

    public function search(Request $request)
    {
        $data = $this->validate($request,
            [
                'term' => 'required|string|max:255',
            ]
        );
        return $this->clientRepository->searchByPhone($data['term']);
    }

    public function update(Request $request)
    {
        $data = $this->validate($request,
            [
                'id' => 'required|integer',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
            ]
        );
        $client = $this->clientRepository->getById($data['id']);
        $this->clientRepository->update($client, $data);
        return redirect('/clients/view/' . $client->id);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $this->validate($request,
                [
                    'name' => 'required|string|max:255',
                    'phone' => 'required|string|max:255',
                ]
            );
            $client = $this->clientRepository->update(null, $data);
            return redirect('/clients/view/' . $client->id);
        }
        else {
            return view('client.add');
        }
    }

    public function unselect(){
        Session::remove('car_id');
        return redirect('/');
    }
}
