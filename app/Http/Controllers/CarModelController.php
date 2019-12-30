<?php

namespace App\Http\Controllers;

use App\Models\CarModel;
use Illuminate\Http\Request;

class CarModelController extends Controller
{
    public function search(Request $request)
    {
        $data = $request->all();
        $query = CarModel::query()
            ->where('ispassengercar', 'True')
            ->select('id', 'constructioninterval as year', 'description as name')
            ->limit(20);

        if (!empty($data['manufacturer_id'])) {
            $query->where('manufacturer_id', $data['manufacturer_id'])->limit(100);
        }

        if (!empty($data['name'])) {
            $query ->where('description', 'like', '%' . $data['name'] . '%');
        }

        return $query->get();
    }
}
