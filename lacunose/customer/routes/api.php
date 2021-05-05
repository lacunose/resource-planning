<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RoutecustomerProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* 
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

/* 
|--------------------------------------------------------------------------
| PROTECTED
|--------------------------------------------------------------------------
*/
// Route::middleware('client')->namespace('API\\Pro')->group(function(){
Route::namespace('API\\Pro')->group(function(){
	Route::prefix('program')->group(function(){
		//READ
		Route::get('{status}', [
		    'as' => 'tcust.api.program.index',  		'uses' 	=> 'ProgramController@index'
		]);
	});
});

/* 
|--------------------------------------------------------------------------
| PRIVATE
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->namespace('API\\Pri')->group(function(){
	Route::prefix('account')->group(function(){
	  Route::get('/{status}',         ['uses' => 'AccountController@index',        'as' => 'api.account.index']);
	  Route::get('show/{id}',         ['uses' => 'AccountController@show',         'as' => 'api.account.show']);
	  Route::post('updated/{id}',     ['uses' => 'AccountController@updated',      'as' => 'api.account.updated']);
	  Route::post('registered/{id}',  ['uses' => 'AccountController@registered',   'as' => 'api.account.registered']);
	  Route::get('paid/{id}/{no}',    ['uses' => 'AccountController@paid',         'as' => 'api.account.paid']);
	  Route::get('unregistered/{id}', ['uses' => 'AccountController@unregistered', 'as' => 'api.account.unregistered']);
	  Route::get('deleted/{id}',      ['uses' => 'AccountController@deleted',      'as' => 'api.account.deleted']);
	});
});

