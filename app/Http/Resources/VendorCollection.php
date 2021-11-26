<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VendorCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($vendor) {
                $response = [
                    'id' => $vendor->id,
                    'vendor_id' => $vendor->vendor_id,
                    'first_name' => $vendor->user->first_name,
                    'last_name' => $vendor->user->last_name,
                    'email' => $vendor->user->email,
                    'phone' => $vendor->user->phone,
                    'role' => config('constants.appRole.'.$vendor->user->app_role),
                    'image' => ($vendor->image) ? asset('uploads/'.$vendor->image) : null,
                    'country' => $vendor->country,
                    'city' => $vendor->city,
                    'address' => $vendor->address,
                    'street' => $vendor->street,
                    'post_code' => $vendor->post_code,
                    'lat' => $vendor->lat,
                    'lng' => $vendor->lng,
                    'parking_image' => asset('uploads/'.$vendor->parking_img),
                    'bill_img' => asset('uploads/'.$vendor->bill_img),
                    'id_type' => $vendor->id_type,
                    'first_image' => $vendor->id_img_1,
                    'sencond_image' => $vendor->id_img_2,
                    'charger_detail' => (object)[
                        'charger_box' => $vendor->charger_box,
                        'charger_plug_type' => $vendor->charger_plug_type,
                        'charger_level' => $vendor->charger_level,
                        'charger_capacity' => $vendor->charger_capacity,
                        'charger_voltage' => $vendor->charger_voltage,
                        'charger_img' => asset('uploads/'.$vendor->charger_img),
                    ]
                ];
                return $response;
            })
        ];
    }
}
