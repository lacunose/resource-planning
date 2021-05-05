<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the accountcustomerProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*account*/
Route::prefix('account')->middleware(['tacl.client', 'tacl.scope:tcust.account.data'])->group(function(){
  Route::get('{status}',          ['uses' => 'AccountController@index',       'as' => 'tcust.account.index']);
  Route::get('show/{id}',         ['uses' => 'AccountController@show',        'as' => 'tcust.account.show']);
  
  Route::get('opening/{id}',      ['uses' => 'AccountController@opening',     'as' => 'tcust.account.opening']);
  Route::post('opened/{id}',      ['uses' => 'AccountController@opened',      'as' => 'tcust.account.opened']);

  Route::post('issued/{id}',      ['uses' => 'AccountController@issued',      'as' => 'tcust.account.issued']);
  Route::get('verified/{id}',     ['uses' => 'AccountController@verified',    'as' => 'tcust.account.verified']);

  Route::delete('closed/{id}',    ['uses' => 'AccountController@closed',      'as' => 'tcust.account.closed']);
});

/*report*/
Route::prefix('report')->middleware(['tacl.client', 'tacl.scope:tcust.log.segment3'])->group(function(){
  Route::get('log/{mode}',       ['uses' => 'ReportController@log',            'as' => 'tcust.report.log']);
});

/*SETTING - PRICING*/
Route::prefix('setting/program')->middleware(['tacl.client', 'tacl.scope:tcust.setting.program'])->group(function(){
  Route::get('{status}',          ['uses' => 'ProgramController@index',       'as' => 'tcust.program.index']);
  Route::get('show/{id}',         ['uses' => 'ProgramController@show',        'as' => 'tcust.program.show']);
  
  Route::get('saving/{id}',       ['uses' => 'ProgramController@saving',      'as' => 'tcust.program.saving']);
  Route::post('saved/{id}',       ['uses' => 'ProgramController@saved',       'as' => 'tcust.program.saved']);
  Route::get('deleted/{id}',      ['uses' => 'ProgramController@deleted',     'as' => 'tcust.program.deleted']);

  Route::post('published/{id}',   ['uses' => 'ProgramController@published',   'as' => 'tcust.program.published']);
  Route::post('unpublished/{id}', ['uses' => 'ProgramController@unpublished', 'as' => 'tcust.program.unpublished']);
});

/*SETTING - CUSTOMER*/
Route::prefix('setting/anggota')->middleware(['tacl.client', 'tacl.scope:tcust.setting.program'])->group(function(){
// Route::prefix('setting/anggota')->middleware(['tacl.client', 'tacl.scope:tcust.setting.customer'])->group(function(){
  Route::get('{status}',        ['uses' => 'CustomerController@index',       'as' => 'tcust.customer.index']);
  Route::get('show/{id}',       ['uses' => 'CustomerController@show',        'as' => 'tcust.customer.show']);
  
  Route::get('updating/{id}',   ['uses' => 'CustomerController@updating',    'as' => 'tcust.customer.updating']);
  Route::post('updated/{id}',   ['uses' => 'CustomerController@updated',     'as' => 'tcust.customer.updated']);
  
  Route::get('deleted/{id}',    ['uses' => 'CustomerController@deleted',     'as' => 'tcust.customer.deleted']);

  Route::get('inactivated/{id}',['uses' => 'CustomerController@inactivated', 'as' => 'tcust.customer.inactivated']);
  Route::get('activated/{id}',  ['uses' => 'CustomerController@activated',   'as' => 'tcust.customer.activated']);

  Route::post('programmed/{id}',  ['uses' => 'CustomerController@programmed',   'as' => 'tcust.customer.programmed']);
  Route::get('unprogrammed/{id}', ['uses' => 'CustomerController@unprogrammed', 'as' => 'tcust.customer.unprogrammed']);

  Route::post('marked/{id}',      ['uses' => 'CustomerController@marked',       'as' => 'tcust.customer.marked']);
  Route::get('unmarked/{id}',     ['uses' => 'CustomerController@unmarked',     'as' => 'tcust.customer.unmarked']);
});
