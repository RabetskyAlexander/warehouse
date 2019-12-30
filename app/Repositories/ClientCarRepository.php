<?php


namespace App\Repositories;


use App\Models\ClientCar;
use App\Models\ClientCarProduct;
use Psy\Command\ClearCommand;

class ClientCarRepository
{
    public function getByClientId(int $client_id)
    {
        return ClientCar::query()
            ->with(['modification'])
            ->where('client_id', $client_id)
            ->get();
    }

    /**
     * @param ClientCar|null $clientCar
     * @param array $data
     * @return ClientCar
     */
    public function update(?ClientCar $clientCar, array $data): ClientCar
    {
        if(!array_key_exists('products', $data)){
            $data['products'] = [];
        }
        $productIds = $data['products'];
        unset($data['products']);

        if ($clientCar === null) {
            $clientCar = new ClientCar();
        }
        if (empty($data['abs'])) {
            $data['abs'] = 0;
        } else {
            $data['abs'] = 1;
        }

        if (empty($data['is_drum'])) {
            $data['is_drum'] = 0;
        } else {
            $data['is_drum'] = 1;
        }

        if (empty($data['is_conditioner'])) {
            $data['is_conditioner'] = 0;
        } else {
            $data['is_conditioner'] = 1;
        }

        $clientCar->setRawAttributes($data);
        $clientCar->save();

        if ($clientCar->products()->count() > 0){
            ClientCarProduct::query()
                ->where('client_car_id', $clientCar->id)
                ->delete();
        }

        foreach ($productIds as $productId) {
            if (!empty($productId)){
                ClientCarProduct::query()
                    ->insertOrIgnore(
                        [
                            'product_id' => $productId,
                            'client_car_id' => $clientCar->id,
                        ]
                    );
            }
        }

        return $clientCar;
    }

    /**
     * @param int $id
     * @return ClientCar
     */
    public function getById(int $id): ClientCar
    {
        return ClientCar::query()->with(
            [
                'products',
                'products.type',
                'products.brand',
                'modification',
                'client',
            ]
        )->findOrFail($id);
    }
}
