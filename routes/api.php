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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route API Graph 
Route::get('/index', 'GraphController@index');
Route::group(['prefix' => 'graphs'], function () {
    Route::post('/store', 'GraphController@store');
    Route::get('/{id}', 'GraphController@show');
    Route::get('/{id}/edit', 'GraphController@edit');
    Route::get('/{id}/statistics', 'GraphController@statistics');
    Route::delete('/{id}', 'GraphController@destroy');
});
