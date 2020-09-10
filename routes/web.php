<?php

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
    return view('welcome');
});
Route::prefix('product')->group(function(){
	Route::view('/', 'product.index');
	Route::get('/get-data', 'ProductC@getData');
	Route::post('/save', 'ProductC@save');
	Route::post('/update', 'ProductC@update');
	Route::post('/delete', 'ProductC@delete');
});