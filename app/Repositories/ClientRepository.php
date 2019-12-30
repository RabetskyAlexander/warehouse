<?php

namespace App\Repositories;


use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientRepository
{
    private $carRepository;

    function __construct(
        CarRepository $repository
    )
    {
        $this->carRepository = $repository;
    }

    /**
     * @param Client|null $client
     * @param array $data
     * @return Client
     */
    public function update(?Client $client,array $data): Client
    {
        if ($client === null)
        {
            $client = new Client();
        }
        $client->setRawAttributes($data);
        $client->save();
        return $client;
    }

    public function getById(int $id)
    {
        return Client::query()->with(['cars', 'cars.modification'])->findOrFail($id);
    }

    public function searchByPhone(string $phone)
    {
        return Client::query()->where('phone', 'like', '%' . $phone . '%')->get();
    }

    public function add($name, $phone){
        $currentUser = 1;
        $id = DB::table('clients')
            ->insertGetId([
               'name' => $name,
                'phone' => $phone,
                'user_id' => $currentUser
            ]);
        return $this->get($id);
    }

   public function updateProps($id, $name, $phone){
        $currentUser = 1;
          DB::table('clients')
            ->where('id',$id)
            ->where('user_id',$currentUser)
            ->update([
                'name' => $name,
                'phone' => $phone,
            ]);
        return response('ok',200);
    }

    public function get($id ){
        $currentUser = 1;
        $client = DB::table('clients')
            ->where('clients.id',$id)
            ->where('user_id',$currentUser)
            ->first();
        $client->cars = $this->carRepository->getByClientId($id);

        return response( json_encode($client),200);
    }

    public function getAll(  ){
        $currentUser = 1;
        $client = DB::table('clients')
            ->where('user_id',$currentUser)
            ->get();
        foreach ( $client as $p )
            $p->cars = $this->carRepository->getByClientId($p->id);

        return response( json_encode($client),200);
    }
}
