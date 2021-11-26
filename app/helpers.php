<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('error_msg_serialize')) {
    /**
     *
     * Error Message Serializing
     *
     */
    function error_msg_serialize($errorList, $innerArray = false)
    {
        $errorData = $errorList;
        $errorData = $errorData->toArray();
        $errors    = [];
        $i         = 0;
        foreach ($errorData as $key => $value) {
            $errors[$i] = $value[0];
            $i++;
        }
        if ($innerArray) {
            return array_values(array_unique($errors));
        }
        return $errors;
    }
}

if (!function_exists('verification_code')) {
    /**
     *
     * Create Confirmation Code for Email Verification
     *
     */
    function verification_code($length = 10, $data = null)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $data . $key;
    }
}

if (!function_exists('sendVerification_code')) {
    /**
     *
     * Create Confirmation Code for Email Verification
     *
     */
    function sendVerification_code($length = 10, $data = null)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $data . $key;
    }
}

if (!function_exists('calculateDistance')) {
    function calculateDistance($lat1, $long1, $lat2, $long2)
    {
        Log::info("API key ".env('MAP_API_KEY'));
        $distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?&origins=' .$lat1.','.$long1 . '&destinations=' . $lat2 .','.$long2. '&key=' . env('MAP_API_KEY') . '');
        $distance_arr = json_decode($distance_data);
        Log::info("geo locaion res -" . json_encode($distance_arr));

        $origin_addresses = "";
        if ($distance_arr->status == 'OK') {
            $destination_addresses = $distance_arr->destination_addresses[0];
            $origin_addresses = $distance_arr->origin_addresses[0];
        }
        if ($origin_addresses == "" or $destination_addresses == "") {
            return false;
        }
        $elements = $distance_arr->rows[0]->elements;
        Log::info("elements -" . json_encode($elements));
        $distance = $elements[0]->distance->text;
        $duration = $elements[0]->duration->text;
        $distanceValue = (float)str_replace('km', '', $distance);
        return ['durations' => $duration, 'distance' => $distance, 'distance_value' => $distanceValue];
    }

}
