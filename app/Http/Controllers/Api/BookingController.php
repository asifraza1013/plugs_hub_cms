<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * get service provider list within specific radius
     */
    public function vendorListUsingRadius(Request $request)
    {
        $rules = [
            'distance' => 'nullable|numeric',
            'lat' => 'required|string',
            'lng' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $distance = ($request->has('distance') && $request->distance) ? $request->distance : 10;
        $distance = $distance + 3;
        $lat = $request->lat;
        $lng = $request->lng;
        Log::info("distance --".$distance);

       $query =  DB::table("service_providers")
        ->select("user_apps_id AS id", DB::raw("6371 * acos(cos(radians(" . $lat . "))
        * cos(radians(lat))
        * cos(radians(lng) - radians(" . $lng . "))
        + sin(radians(" .$lat. "))
        * sin(radians(lat))) AS distance"),'vendor_id', 'country', 'city', 'address', 'street', 'post_code', 'lat', 'lng')
        ->having('distance', '<', $distance)
        ->get();

        Log::info("distance results --".json_encode($query));

        if(count($query)){
            return response()->json([
                'status' => true,
                'data' => $query,
                'code' => config('response.1011.code'),
                'message' => config('response.1011.message'),
            ]);
        }
        return response()->json([
            'status' => false,
            'code' => config('response.1012.code'),
            'message' => config('response.1012.message'),
        ]);
    }

    /**
     * get vendor location detail
     */

    public function vendorLocationDetailWithDistanceTime(Request $request)
    {
        $rules = [
            'vendor_id' => 'required|numeric',
            'lat' => 'required|string',
            'lng' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $vendor = ServiceProvider::where('user_apps_id', $request->vendor_id)
        ->select('user_apps_id AS id', 'vendor_id', 'country', 'city', 'address', 'street', 'post_code', 'lat', 'lng', 'parking_img')
        ->first();
        if($vendor){
            $response = calculateDistance($request->lat, $request->lng, $vendor->lat, $vendor->lng);
            Log::info("matric res - ".json_encode($response).' vendor '.$request->vendor_id);

            if($response){
                $vendor->distance = $response['distance_value'];
                $vendor->distance_with_unit = $response['distance'];
                $vendor->duration = $response['durations'];
                $vendor->parking_img = asset('uploads/'.$vendor->parking_img);
                return response()->json([
                    'status' => true,
                    'data' => $vendor,
                    'code' => config('response.1014.code'),
                    'message' => config('response.1014.message'),
                ]);
            }
            return response()->json([
                'status' => false,
                'code' => config('response.1013.code'),
                'message' => config('response.1013.message'),
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'code' => config('response.1012.code'),
                'message' => config('response.1012.message'),
            ]);
        }
    }

    /**
     * craete new booking
     */
    public function createNewBooking(Request $request)
    {
        $rules = [
            'distance' => 'nullable|numeric',
            'lat' => 'required|string',
            'lng' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }
    }

}
