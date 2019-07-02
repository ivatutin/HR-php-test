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

Route::get('/', function () {return view('welcome');})->name('index');


Route::any('wheather', 'WheatherController')->name('wheather');
Route::get('order-list', 'OrderController@list')->name('order.list');
Route::get('order-list/{id}', 'OrderController@edit')->name('order.edit');
Route::post('order-list/{id}', 'OrderController@update')->name('order.update');
Route::get('product-list', 'ProductController@list')->name('product.list');
Route::post('product-list/{id}', 'ProductController@update')->name('product.update');