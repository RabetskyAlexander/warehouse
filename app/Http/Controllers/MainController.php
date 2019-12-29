<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Manufacturers;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductLink;
use App\Models\ProductLinks;
use App\Models\ProductType;
use App\Repositories\ClientCarRepository;
use App\Repositories\ManufactureRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    private $brandsDelete = [7,16,4943 ];
    private $brands = [
        2,
3,
4,
5,
6,
9,
10,
11,
14,
15,
23,
24,
26,
30,
31,
32,
33,
34,
35,
37,
38,
39,
42,
50,
52,
54,
55,
56,
57,
60,
62,
64,
65,
66,
71,
72,
75,
79,
81,
83,
85,
88,
95,
101,
110,
113,
121,
123,
126,
127,
134,
137,
139,
140,
141,
151,
153,
154,
156,
159,
161,
162,
163,
169,
176,
178,
        185,
188,
192,
197,
199,
202,
204,
208,
215,
218,
220,
222,
225,
234,
235,
236,
239,
240,
244,
245,
247,
256,
260,
268,
271,
279,
283,
287,
301,
316,
317,
323,

331,
350,
356,
367,
373,
380,
387,
388,
389,
397,
430,
432,
436,
449,
478,
485,
494,
4003,
4005,
4006,
4449,
4460,
4470,
4512,
4520,
4553,
4558,
4576,
4595,
4620,
4664,
4667,
4671,
4674,
4679,
4703,
4705,
4727,
4728,
4866,
4871,
4880,
4881,
4907,
4923,
];
    public function index()
    {
        $data = [];
        if ( Session::exists('car_id')) {
            $data['car'] = (new ClientCarRepository())->getById(Session::get('car_id'));
        }
        return view('index')->with($data);
    }

    public function deleteLinks(){
        set_time_limit(0);

        ini_set("memory_limit", "20000M");

        ProductLinks::query()
            ->whereNotIn('supplierid',$this->brands)
            ->delete();
    }

    public function test()
    {
        $this->changeImages();

        die();
        set_time_limit(0);
        ini_set("memory_limit", "20000M");
        $images = ProductImage::all();
        foreach ($images as $image) {
            $product = Product::query()
                ->where('name', $image->DataSupplierArticleNumber)
                ->where('brand_id', $image->supplierId)
                ->first();
            if ($product) {
                $image->product_id = $product->id;
                $image->save();
            }
        }
    }

    public function updateImage(){
        set_time_limit(0);
        ini_set("memory_limit", "20000M");
        $images = ProductImage::all();
        foreach ($images as $image) {
            $product = Product::query()->find($image->product_id);
            if ($product) {
                $image->src = $product->brand_id . '/' . $image->src;
                $image->save();
            }
        }
    }

    function xcopy($source, $dest, $permissions = 0755)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            $this->xcopy("$source/$entry", "$dest/$entry", $permissions);
        }

        // Clean up
        $dir->close();
        return true;
    }

    public function fixImage(){
        set_time_limit(0);
        ini_set("memory_limit", "20000M");

        ProductImage::query()->chunk(500000,function ($images){
                    foreach ($images as $img){
                        $names = explode('.', $img->src);
                        if (count($names)>=2) {
                            $name = $names[0] . '.' . strtolower($names[1]);
                            $img->src = $name;
                            $img->save();
                        }
                    }
        });
    }

    public function fixLinks(){
        set_time_limit(0);
        ini_set("memory_limit", "20000M");

        ProductLink::query()->where('product_id', 0)->chunk(100000,function ($productLinks){
            foreach ($productLinks as $productLink){
                DB::table('passanger_car_pds')
                    ->where('supplierid', $productLink->supplierid)
                    ->where('productid', $productLink->productid)
                    ->where('passangercarid', $productLink->linkagetypeid)
                    ->delete();
            }
        });
    }

    public function fixProducts(){
        set_time_limit(0);
        ini_set("memory_limit", "20000M");

        ProductLink::query()->where('product_id', 0)->chunk(500000,function ($productLinks){
            foreach ($productLinks as $productLink){
               $product = Product::query()
                   ->where('name', $productLink['datasupplierarticlenumber'])
                   ->where('brand_id', $productLink['supplierid'])
                   ->first();
               if ($product)
               {
                   $productLink->product_id = $product->id;
                   $productLink->save();
               }
            }
        });
    }

function Move_Folder_To($source, $target){
    @mkdir($target);
    rename( $source,  $target);
}

    private function changeImages()
    {
set_time_limit(0);
        $public = public_path();
        foreach ($this->brands as $brand) {
            $old = $public . '/images/' . $brand;
            $new = $public . '/images2/' . $brand;

          //  shell_exec("cp -r $old $new");
           $this->xcopy($old, $new);
        }
    }


    private function remove()
    {
        $carBrands = (new ManufactureRepository())->getForCar();

        foreach ($carBrands as $carBrand) {

        }
    }

    public function fixType(){
        set_time_limit(0);
        ini_set("memory_limit", "20000M");
        $types = ProductType::all();
        $group = $types->groupBy('name');
        foreach ($group as $types)
        {
            if ($types->count() > 1){
                $productTypeIds = $types->pluck('id');

                Product::query()
                    ->whereIn('type_id', $productTypeIds)
                    ->update(
                        [
                            'type_id' => $productTypeIds[0]
                        ]
                    );
                $productTypeIds->shift();
                ProductType::query()
                    ->whereIn('id', $productTypeIds)
                    ->delete();
            }
        }
    }


}
