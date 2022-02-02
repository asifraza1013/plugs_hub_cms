<?php

namespace App\Http\Controllers\Api;

use App\ChargerInfo;
use App\Http\Controllers\Controller;
use App\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServiceProviderController extends Controller
{
    /**
     * server provider signup
     */
    public function providorDetail(Request $request)
    {
        $rules = [
            'country' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'lat' => 'required|string',
            'lng' => 'required|string',
            'street' => 'required|string',
            'post_code' => 'required|string',

            'charger_box' => 'required|array',
            'charger_plug_type' => 'required|array',
            'charger_level' => 'required|array',
            'charger_capacity' => 'required|array',
            'charger_voltage' => 'required|array',
            'charger_img' => 'required|array',

            'id_type' => 'required|string|in:NID,Passport',
            // 'passport_img' => 'required|string',

            'bill_img' => 'required|string',
            'parking_img' => 'required|string',
        ];

        if($request->id_type == 'NID'){
            $rules['front_img'] = 'required|string';
            $rules['back_img'] = 'required|string';
        }
        else{
            $rules['passport_img'] = 'required|string';
        }
        $validator = Validator::make($request->all(), $rules);
        $errors = error_msg_serialize($validator->errors());
        if (count($errors) > 0)
        {
            return response()->json(['status' => false, 'status_code' => 1013, 'data' => $errors]);
        }

        $user = $request->user();

        // generate unique id.
        $vendorId = random_int(1000, 9999);
        $vendorData = 'SP-'.$vendorId;

        // add user charger details
        $chargerDetail = [];
        foreach($request->charger_box as $key=>$charger){

            // $charger_img = json_decode($request->parking_img[$key]);  // your base64 encoded
            // $charger_img = str_replace('data:image/png;base64,', '', $charger_img);
            // $charger_img = str_replace(' ', '+', $charger_img);
            // $chargerName = random_int(1000000, 9999999).'.'.'png';
            // File::put(public_path('uploads/'.$chargerName), base64_decode($charger_img));
            $data = [
                'user_apps_id' => (string)$user->id,
                'charger_box' => $charger,
                'charger_plug_type' => $request->charger_plug_type[$key],
                'charger_level' => $request->charger_level[$key],
                'charger_capacity' => $request->charger_capacity[$key],
                'charger_voltage' => $request->charger_voltage[$key],
                'charger_img' => $request->parking_img[$key],
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ];

            array_push($chargerDetail, $data);
        }

        Log::info("charger Info--".json_encode($chargerDetail));
        // return response()->json($chargerDetail);
        // save charger info
        ChargerInfo::insert($chargerDetail);

        // save images
        // $bill_image = $request->bill_img;  // your base64 encoded
        // $bill_image = str_replace('data:image/png;base64,', '', $bill_image);
        // $bill_image = str_replace(' ', '+', $bill_image);
        // $billName = random_int(1000000, 9999999).'.'.'png';
        // File::put(public_path('uploads/'.$billName), base64_decode($bill_image));

        // $parking_img = $request->parking_img;  // your base64 encoded
        // $parking_img = str_replace('data:image/png;base64,', '', $parking_img);
        // $parking_img = str_replace(' ', '+', $parking_img);
        // $parkingName = random_int(1000000, 9999999).'.'.'png';
        // File::put(public_path('uploads/'.$parkingName), base64_decode($parking_img));

        // if($request->id_type == 'NID'){
        //     $front_img = $request->front_img;  // your base64 encoded
        //     $front_img = str_replace('data:image/png;base64,', '', $front_img);
        //     $front_img = str_replace(' ', '+', $front_img);
        //     $frontName = random_int(1000000, 9999999).'.'.'png';
        //     File::put(public_path('uploads/'.$frontName), base64_decode($front_img));

        //     $back_img = $request->back_img;  // your base64 encoded
        //     $back_img = str_replace('data:image/png;base64,', '', $back_img);
        //     $back_img = str_replace(' ', '+', $back_img);
        //     $backName = random_int(1000000, 9999999).'.'.'png';
        //     File::put(public_path('uploads/'.$backName), base64_decode($back_img));
        // }else{
        //     $passport_img = $request->passport_img;  // your base64 encoded
        //     $passport_img = str_replace('data:image/png;base64,', '', $passport_img);
        //     $passport_img = str_replace(' ', '+', $passport_img);
        //     $passportName = random_int(1000000, 9999999).'.'.'png';
        //     File::put(public_path('uploads/'.$passportName), base64_decode($passport_img));
        // }

        // register user
        $vendorData = [
            'user_apps_id' => $user->id,
            'vendor_id' => $vendorData,
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'street' => $request->street,
            'post_code' => $request->post_code,
            'id_type' => $request->id_type,
            'bill_img' => $request->bill_img,
            'parking_img' => $request->parking_img,
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ];

        if($request->id_type == 'NID'){
            $vendorData['id_img_1'] = $request->front_img;
            $vendorData['id_img_2'] = $request->back_img;
        }else{
            $vendorData['id_img_1'] = $request->passport_img;
        }

        Log::info("user detail -- ".json_encode($vendorData).'  user_id'.$user->id);

        ServiceProvider::updateOrCreate(
            ['user_apps_id' => $user->id],
            $vendorData
        );
        return response()->json([
            'status' => true,
            'code' => config('response.1010.code'),
            'message' => config('response.1010.message'),
        ]);
    }
}
