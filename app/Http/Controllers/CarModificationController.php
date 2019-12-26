<?php

namespace App\Http\Controllers;

use App\Models\CarModification;
use Illuminate\Http\Request;

class CarModificationController extends Controller
{
    public function search(Request $request)
    {
        $data = $request->all();

        $query = CarModification::query()
            ->select(
                'constructioninterval as year',
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
            ->limit(20);

        if (!empty($data['model_id'])) {
            $query->where('modelid', $data['model_id'])->limit(100);
        }

        if (!empty($data['name'])) {
            $query->where('fulldescription', 'like' , '%' . $data['name'] . '%');
        }

        return $query->get();
    }
}
