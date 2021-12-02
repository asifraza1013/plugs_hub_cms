<?php

namespace App\Http\Controllers\Api;

use App\ChargerBox;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChargerInfoManagementController extends Controller
{
    /**
     * get charger info management
     */
    public function chargerInfo(Request $request)
    {
        $allData = ChargerBox::where('status', 'active')
        ->where('type', '!=', 3)
        ->get();
        // $chargerType = ChargerBox::where('type', 2)
        // ->where('status', 'active')
        // ->get();
        $chargerBox = [];
        $chargerType = [];
        foreach($allData as $item){
            if($item->type = 2){
                $value = (object)[
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => asset('uploads/'.$item->image.'_thumbnail'.'.jpg'),
                ];
                array_push($chargerType, $value);
            }
            if($item->type = 1){
                $value = (object)[
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => asset('uploads/'.$item->image.'_thumbnail'.'.jpg'),
                ];
                array_push($chargerBox, $value);
            }
        }
        $level = config('constants.charger_level');
        $capacity = config('constants.charger_capacity');
        $voltage = config('constants.charger_voltage');

        return response()->json([
            'status' => true,
            'data' => (object)[
                'charger_box' => $chargerBox,
                'charger_plug_type' => $chargerType,
                'charger_level' => $level,
                'charger_capacity' => $capacity,
                'charger_voltage' => $voltage,
            ],
            'code' => config('response.1017.code'),
            'message' => config('response.1017.message'),
        ]);
    }

    /**
     * get car brand list
     */
    public function getCarBrandList(Request $request)
    {
        $carBrand = ChargerBox::where('type', 3)
        ->where('status', 'active')
        ->get();
        $data = [];
        foreach($carBrand as $item){
            $value = (object)[
                'id' => $item->id,
                'name' => $item->name,
                'image' => asset('uploads/'.$item->image.'_thumbnail'.'.jpg'),
            ];
            array_push($data, $value);
        }
        return response()->json([
            'status' => true,
            'data' => $data,
            'code' => config('response.1021.code'),
            'message' => config('response.1021.message'),
        ]);
    }
}
