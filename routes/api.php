<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('category', 'CategoryController@index');
    Route::get('category/{id}', 'CategoryController@show');
    Route::post('category', 'CategoryController@store');
    Route::put('category', 'CategoryController@update');
    Route::delete('category/{id}', 'CategoryController@destroy');

    Route::get('athor', 'AthorController@index');
    Route::get('athor/{id}', 'AthorController@show');
    Route::post('athor', 'AthorController@store');
    Route::put('athor', 'AthorController@update');
    Route::delete('athor/{id}', 'AthorController@destroy');

    Route::get('cast', 'CastController@index');
    Route::get('cast/{id}', 'CastController@show');
    Route::post('cast', 'CastController@store');
    Route::put('cast', 'CastController@update');
    Route::delete('cast/{id}', 'CastController@destroy');

    Route::get('movie', 'MovieController@index');
    Route::get('movie/{id}', 'MovieController@show');
    Route::post('movie', 'MovieController@store');
    Route::put('movie', 'MovieController@update');
    Route::delete('movie/{id}', 'MovieController@destroy');
});

// Route::resource('/category', 'CategoryController');
