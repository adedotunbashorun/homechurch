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

// Route::middleware('auth:api')->get('/homechurches', function (Request $request) {
//     return $request->user();
// });

Route::get('/church/homechurches/{id}', [
    'as' => 'api.homechurches.church',
    'uses' => 'HomechurchesApiController@getByChurch'
]);

Route::get('/state/homechurches/{id}', [
    'as' => 'api.homechurches.state',
    'uses' => 'HomechurchesApiController@getByState'
]);