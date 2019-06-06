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

Route::POST('/api/v1/user/check', 'UserController@check');

Route::POST('/api/v1/user/rep', 'ReputationController@rep');

Route::POST('/api/v1/user/item/random', 'UserItemsController@create');

Route::POST('/api/v1/user/items', 'UserItemsController@index');


Route::POST('/api/v1/user/daily', 'UserController@daily');

Route::POST('/api/v1/user/item/sell', 'UserItemsController@sell');

Route::POST('/api/v1/user/item/give', 'UserItemsController@give');