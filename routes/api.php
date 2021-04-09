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

/* 
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::domain(env('APP_BASE', 'localhost'))->get('config', function (Request $request) {
	$pay  		= [];

	return response()->json([
        'status' => true,
        'data'   => ['version' => env('CONFIG_VERSION', 1), 'web' => config()->get('web')],
        'message'=> 'Data Berhasil Diambil',
    ]);
});


/* 
|--------------------------------------------------------------------------
| PROTECTED
|--------------------------------------------------------------------------
*/

/* 
|--------------------------------------------------------------------------
| PRIVATE
|--------------------------------------------------------------------------
*/
Route::middleware('auth:api')->namespace('Dashboard\\API')->group(function(){
	Route::get('config', function (Request $request) {
		$pay  		= [];
		$note  		= [];
	    $file 		= 'config/tsale/payment.json';
	    $file2 		= 'config/tsale/note.json';
	    
	    if (Storage::disk(config()->get('tsale.mode'))->exists($file)) {
	        $pay	= json_decode(Storage::disk(config()->get('tsale.mode'))->get($file), true);
	        $note	= json_decode(Storage::disk(config()->get('tsale.mode'))->get($file2), true);
	    }

		return response()->json([
	        'status' => true,
	        'data'   => [
	        	'version' 	=> env('CONFIG_VERSION', 2), 
	        	'sale' 		=> ['payment' => $pay, 'note' => $note, 'subsystem' => config()->get('tsale')]
	        ],
	        'message'=> 'Data Berhasil Diambil',
	    ]);
	});

	Route::get('whoami', function (Request $request) {
		$user 	= \App\User::where('id', Auth::id())->with(['accesses', 'accesses.endpoints'])->firstorfail();
	    return $user;
	});

	//OVERRIDE SALES
	Route::prefix('sale/transaksi')->group(function(){
		Route::post('discuss/{no}', [
		    'as' => 'api.transaction.discuss',  		'uses' 	=> 'TransactionController@discuss'
		]);

		Route::get('discussion/{no}', [
		    'as' => 'api.transaction.discussion',		'uses' 	=> 'TransactionController@discussion'
		]);

		Route::get('show/{no}', [
		    'as' => 'api.transaction.show',				'uses' 	=> 'TransactionController@show'
		]);


		Route::post('process/{process}', [
		    'as' => 'api.transaction.process',			'uses' 	=> 'TransactionController@process'
		]);
	});

	//OVERRIDE WAREHOUSE
	Route::prefix('warehouse/dokumen/{cause}')->group(function(){
		Route::post('submitted', [
		    'as' => 'api.document.submitted',  			'uses' 	=> 'DocumentController@submitted'
		]);

		Route::post('locked', [
		    'as' => 'api.document.locked',  			'uses' 	=> 'DocumentController@locked'
		]);

		Route::post('unpacked/{id}', [
		    'as' => 'api.document.unpacked',  			'uses' 	=> 'DocumentController@unpacked'
		]);
	});

	//tool
	Route::prefix('tools')->namespace('\\Lacunose\\Swirl\\Http\\Controllers\\API')->group(function(){
		Route::get('search/{ref}', [
		    'as' => 'api.tools.search',				'uses' 	=> 'ToolsController@search'
		]);
	});
});

