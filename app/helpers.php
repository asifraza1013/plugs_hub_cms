<?php

if (!function_exists('error_msg_serialize')) {
    /**
     *
     * Error Message Serializing
     *
     */
    function error_msg_serialize($errorList, $innerArray = false) {
        $errorData = $errorList;
        $errorData = $errorData->toArray();
        $errors    = [];
        $i         = 0;
        foreach ($errorData as $key => $value) {
            $errors[$i] = $value[0];
            $i++;
        }
        if($innerArray) {
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
    function verification_code($length = 10, $data = null) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $data.$key;
    }
}

if (!function_exists('sendVerification_code')) {
    /**
     *
     * Create Confirmation Code for Email Verification
     *
     */
    function sendVerification_code($length = 10, $data = null) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $data.$key;
    }
}


