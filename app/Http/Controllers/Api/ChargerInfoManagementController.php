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
        $chargerBox = ChargerBox::where('type', 1)
        ->where('status', 'active')
        ->pluck('name', 'id');
        $chargerType = ChargerBox::where('type', 2)
        ->where('status', 'active')
        ->pluck('name', 'id');
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
}
