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
define('PAGINATION_COUNT', 10);
Route::get('/', function () {
    return view('welcome');
});
######################## albums #####################
Route::group(['namespace'=> 'App\Http\Controllers\Shipments'], function(){
    Route::get('/', 'ShipmentController@index')->name('Shipment');
    Route::get('createNewShipment', 'ShipmentController@addNew')->name('addNewShipment');
    Route::post('createNewAlbum/store', 'ShipmentController@store')->name('Shipment.store');
    Route::get('Album/edit/{id}', 'ShipmentController@edit')->name('Shipment.edit');
    Route::post('Album/update/{id}', 'ShipmentController@update')->name('Shipment.update');
    Route::post('Album/delete/{id}', 'ShipmentController@destroy')->name('Shipment.delete');

});


######################### pictures ##########################
Route::group(['namespace'=> 'App\Http\Controllers\Picture'], function(){
    Route::post('Album/pic/delete/{id}', 'PicturesController@destroy')->name('pic.destroy');
});
