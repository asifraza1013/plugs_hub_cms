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


Route::group(['prefix' => 'customer', 'namespace' => 'Api'], function () {
    Route::post('/login', 'LoginController@customerEmailLogin');
    Route::post('/signup', 'LoginController@userSignUp');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/update_vehicle_detail', 'LoginController@updateCarDetail');
    });
});
