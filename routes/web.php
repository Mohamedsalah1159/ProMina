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
Route::group(['namespace'=> 'App\Http\Controllers\Album'], function(){
    Route::get('/', 'Albums@index')->name('albums');
    Route::get('createNewAlbum', 'Albums@addNew')->name('addNewAlbum');
    Route::post('createNewAlbum/store', 'Albums@store')->name('album.store');
    Route::get('Album/edit/{id}', 'Albums@edit')->name('album.edit');
    Route::post('Album/update/{id}', 'Albums@update')->name('album.update');
    Route::post('Album/delete/{id}', 'Albums@destroy')->name('album.delete');

});


######################### pictures ##########################
Route::group(['namespace'=> 'App\Http\Controllers\Picture'], function(){
    Route::post('Album/pic/delete/{id}', 'PicturesController@destroy')->name('pic.destroy');
});
