<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.03.2018
 * Time: 16:30
 */

namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class CarRepository
{

    public function getMarks($name){
        $result = DB::table('manufacturers')
            ->where('manufacturers.description', 'LIKE', $name.'%')
            ->select('manufacturers.id','manufacturers.description as name')
            ->where('is_show',true)
            ->limit(10)
            ->distinct()
            ->get()
            ->toJson();
        return response($result,200);
    }

    public function getModelByManufactureId($id){
        $result = DB::table('models')
            ->where('manufacturerid',$id)
            ->where('ispassengercar','True')
            ->select('id','constructioninterval as year','description as name')
            ->get()
            ->toJson();
        return response($result,200);
    }

    public function getModificationByModelId($id){
        $result = DB::table('passanger_cars')
            ->where('modelid',$id)
            ->select('constructioninterval as year',
                'fulldescription as model',
                'capacity_1 as cube',
                'KW',
                'HP',
                'cylinders',
                'fuelType as fuel',
                'bodyType',
                'engineCode',
                'id',
                'driveType'

            )
            ->get()
            ->toJson();
        return response($result,200);
    }

    public function getByClientId($id){
        return DB::table('client_cars')
            ->join('passanger_cars','passanger_cars.id','client_cars.modification_id')
            ->where('client_id',$id)
            ->select('client_cars.*',
                'passanger_cars.fulldescription as name',
                'passanger_cars.HP',
                'passanger_cars.KW',
                'passanger_cars.engineCode as motor'
                )
            ->get() ;
    }

    public function get($id){
        $result =  DB::table('client_cars')
            ->where('id',$id)
            ->first();

        return response(json_encode($result),200);
    }

    public function delete($id){
        try {
             DB::table('client_cars')
                 ->where('id',$id)
                 ->delete();
            return response('ok',200);
        }
        catch (Exception $exception){ return response($exception,500);}
    }

    public function addCar($id){
        try {
             $id = DB::table('client_cars')
                ->insertGetId([
                    'client_id' => $id,
                ]);

             return $this->get($id);
        }
        catch (Exception $exception){ return response($exception,500);}
    }

    public function update($car){
        try {
            DB::table('client_cars')

                ->where('id',$car['id'])
                ->update([
                    'modification_id' => $car['modification_id'],
                    'year' => $car['year'],
                    'vin' => $car['vin'],
                    'abs' => $car['abs'],
                    'is_drum' => $car['is_drum'],
                    'is_conditioner' => $car['is_conditioner'],

                    'oil_filter' => $car['oil_filter'],
                    'oil_filter_name' => $car['oil_filter_name'],

                    'air_filter' => $car['air_filter'],
                    'air_filter_name' => $car['air_filter_name'],

                    'fuel_filter' => $car['fuel_filter'],
                    'fuel_filter_name' => $car['fuel_filter_name'],

                    'air_cabin_filter' => $car['air_cabin_filter'],
                    'air_cabin_filter_name' => $car['air_cabin_filter_name'],

                    'oil' => $car['oil'],
                    'oil_name' => $car['oil_name'],

                    'disc_front' => $car['disc_front'],
                    'disc_front_name' => $car['disc_front_name'],

                    'disk_back' => $car['disk_back'],
                    'disk_back_name' => $car['disk_back_name'],

                    'brake_parts_back' => $car['brake_parts_back'],
                    'brake_parts_back_name' => $car['brake_parts_back_name'],

                    'brake_parts_front' => $car['brake_parts_front'],
                    'brake_parts_front_name' => $car['brake_parts_front_name'],

                    'grm' => $car['grm'],
                    'grm_name' => $car['grm_name'],

                    'candles' => $car['candles'],
                    'candles_name' => $car['candles_name'],

                    'coolant' => $car['coolant'],
                    'coolant_name' => $car['coolant_name']
                ]);

            return $this->getByClientId($car['client_id']);
        }
        catch (Exception $exception){ return response($exception,500);}
    }
}