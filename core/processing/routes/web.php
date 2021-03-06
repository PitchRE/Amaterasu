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

Route::POST('/api/v1/user/recipe/make', 'RecipeController@make');

Route::POST('/api/v1/user/recipes/all', 'RecipeController@all');

Route::POST('/api/v1/user/recipes/available', 'RecipeController@available');

Route::POST('/api/v1/user/skills', 'UserSkillController@index');

Route::POST('/api/v1/user/skill/buy', 'UserSkillController@buy');

Route::POST('/api/v1/user/chances', 'UserController@chances');

Route::GET('/api/test', 'UserController@ttest');