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
	Route::prefix('auth')->namespace('App\Http\Controllers\Users')->group(function() {
		Route::post('register', 'OngController@register');
		Route::post('login', 'OngController@login');
		Route::put('activate/{id}', 'OngController@activate');
	});
	Route::prefix('auth')->namespace('App\Http\Controllers\Users')->middleware('check-token')->group(function() {
		Route::post('logout', 'OngController@logout');
		Route::post('me', 'OngController@me');
	});
});

Route::prefix('info')->middleware('check-token')->group(function() {
	Route::prefix('users')->namespace('App\Http\Controllers\Users')->group(function() {
		Route::get('list', 'OngController@index');
	});

	Route::prefix('objects')->namespace('App\Http\Controllers\Objects')->group(function() {
		Route::get('telephone/list/{id}', 'TelefoneController@index');
		Route::get('address/list/{id}', 'EnderecoController@index');
	});	
});	

Route::prefix('doador')->group(function() {
	Route::prefix('auth')->namespace('App\Http\Controllers\Users')->group(function() {
		Route::post('register', 'DoadorController@register');
		Route::post('login', 'DoadorController@login');
		Route::put('activate/{id}', 'DoadorController@activate');
	});
	Route::prefix('auth')->namespace('App\Http\Controllers\Users')->middleware('check-token')->group(function(){
		Route::post('logout', 'DoadorController@logout');
		Route::post('me', 'DoadorController@me');
	});
});


