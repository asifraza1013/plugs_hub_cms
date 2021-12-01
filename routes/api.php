<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/signup', 'Api\LoginController@userSignUp');
Route::post('/send_otp', 'Api\LoginController@sendOtp');
Route::post('/verif_otp', 'Api\LoginController@verifyOtp');
Route::group(['prefix' => 'customer', 'namespace' => 'Api'], function () {
    Route::post('/login', 'LoginController@customerEmailLogin');
    Route::post('/charger_info', 'ChargerInfoManagementController@chargerInfo');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/update_vehicle_detail', 'LoginController@updateCarDetail');
        Route::post('/update_profile_image', 'LoginController@updateProfileImage');
        Route::post('/vendor_with_radius', 'BookingController@vendorListUsingRadius');
        Route::post('/vendor_radius_detail', 'BookingController@vendorLocationDetailWithDistanceTime');
    });
});

Route::group(['prefix' => 'vendor', 'namespace' => 'Api'], function () {
    Route::post('/login', 'LoginController@customerEmailLogin');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/add_detail', 'ServiceProviderController@providorDetail');
    });
});
