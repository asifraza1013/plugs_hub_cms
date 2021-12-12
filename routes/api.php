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
    Route::post('/car_brand_list', 'ChargerInfoManagementController@getCarBrandList');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/update_vehicle_detail', 'LoginController@updateCarDetail');
        Route::post('/update_profile_image', 'LoginController@updateProfileImage');
        Route::post('/vendor_with_radius', 'BookingController@vendorListUsingRadius');
        Route::post('/vendor_radius_detail', 'BookingController@vendorLocationDetailWithDistanceTime');

        Route::post('/create_booking_request', 'OrderManagementController@requestChargerBooking');
        Route::post('/profile', 'LoginController@userProfile');
    });
});

Route::group(['prefix' => 'vendor', 'namespace' => 'Api'], function () {
    Route::post('/login', 'LoginController@customerEmailLogin');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/add_detail', 'ServiceProviderController@providorDetail');
    });
});


// common APIs
Route::group(['namespace' => 'Api', 'middleware' => 'auth:api'], function () {
    Route::post('/order_list', 'OrderManagementController@orderList');
    Route::post('/approve_charger_req', 'OrderManagementController@approveChargerReq');
    Route::post('/cencel_charger_req', 'OrderManagementController@cancelChargerReq');
    Route::post('/order_detail', 'OrderManagementController@orderDetail');
});
