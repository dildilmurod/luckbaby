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

Route::get('/user', 'Api\UserController@display');

Auth::routes();

Route::get('/', 'PageController@index');

Route::get('/record', 'RecordController@index');
Route::get('/record/{id}', 'RecordController@show');

//Route::post('record', 'RecordController@store');

//Route::get('/all', 'FinanceController@all');
