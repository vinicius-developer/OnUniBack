<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('ong')->group(function() {
	Route::prefix('auth')->namespace('App\Http\Controllers\Ongs')->group(function() {
		Route::post('register', 'OngController@register');
		Route::post('login', 'OngController@login');
		Route::put('activate/{id}', 'OngController@activate');
	});
	Route::prefix('auth')->namespace('App\Http\Controllers\Ongs')->middleware('check-token')->group(function() {
		Route::post('logout', 'OngController@logout');
		Route::post('me', 'OngController@me');
	});
});

Route::prefix('info')->middleware('check-token')->namespace('App\Http\Controllers\Ongs')->group(function() {
	Route::get('list', 'OngController@index');
});	