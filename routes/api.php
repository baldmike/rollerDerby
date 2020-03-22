<?php

use Illuminate\Http\Request;

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

Route::post('/login', 'Api\AuthController@login');
Route::post('/register', 'Api\AuthController@register');
Route::post('/logout', 'Api\AuthController@logout');

Route::resource('item', 'Api\ItemsController');

Route::middleware('auth:api')->group(function () {
    
    Route::get('/user', 'Api\UsersController@current');
    Route::get('/users', 'Api\UsersController@index');
    Route::get('/items', 'Api\ItemsController@index');
    
});

