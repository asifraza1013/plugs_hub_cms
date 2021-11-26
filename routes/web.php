<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

Route::get('/unauthorized', 'HomeController@unauthorized')->name('unauthorized');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('products','ProductController');
    Route::resource('chargerbox','ChargerInfoController');
    Route::get('customer','CustomerController@index')->name('admin.customer.list');
    Route::delete('change_status/{id}','CustomerController@destroy')->name('admin.customer.change.status');

    Route::get('vendors','ManagerServiceProviderController@vendorList')->name('admin.vendors.list');
    Route::get('vendor-show/{id}','ManagerServiceProviderController@vendorDetail')->name('admin.vendors.detail');
    Route::get('approve/{id}','ManagerServiceProviderController@approve')->name('admin.vendor.approve');

    Route::resource('settings', 'SettingsController');
});

