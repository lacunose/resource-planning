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

Route::middleware('auth:web')->group(function(){
	Route::get('/', 		'DashboardController@index')->name('dashboard');

	/*BISNIS*/
	Route::prefix('stock/onhold')->middleware('tacl.scope:app.stock.onhold')->group(function(){
	  Route::get('/',       ['uses' => 'ManagementController@onhold_get',    	'as' => 'app.onhold.get']);
	  Route::post('/',      ['uses' => 'ManagementController@onhold_post',   	'as' => 'app.onhold.post']);
	});

	Route::prefix('conflict')->middleware('tacl.scope:app.conflict.segment')->group(function(){
	  Route::get('{topic}', ['uses' => 'ManagementController@conflict_get',		'as' => 'app.conflict.get']);
	});
});

