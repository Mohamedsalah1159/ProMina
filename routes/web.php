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
######################## Shipments #####################
Route::group(['namespace'=> 'App\Http\Controllers\Shipments'], function(){
    Route::get('/', 'ShipmentController@index')->name('Shipment');
    Route::get('createNewShipment', 'ShipmentController@addNew')->name('addNewShipment');
    Route::post('createNewShipment/store', 'ShipmentController@store')->name('Shipment.store');
    Route::post('changeStatus/pending/{id}', 'ShipmentController@ChangeStatusToPending')->name('Shipment.pending');
    Route::post('changeStatus/progress/{id}', 'ShipmentController@ChangeStatusToProgress')->name('Shipment.progress');
    Route::post('changeStatus/done/{id}', 'ShipmentController@ChangeStatusToDone')->name('Shipment.done');
    Route::get('shipment/edit/{id}', 'ShipmentController@edit')->name('Shipment.edit');
    Route::post('shipment/update/{id}', 'ShipmentController@update')->name('Shipment.update');
    Route::post('shipment/delete/{id}', 'ShipmentController@destroy')->name('Shipment.delete');
});




######################### Journal Entity ##########################
Route::group(['namespace'=> 'App\Http\Controllers\JournalEntity'], function(){
    Route::get('allJournals', 'JournalEntityController@index')->name('journal');
    Route::post('journal/store', 'JournalEntityController@store')->name('journal.store');

    Route::post('Album/pic/delete/{id}', 'PicturesController@destroy')->name('pic.destroy');
});
