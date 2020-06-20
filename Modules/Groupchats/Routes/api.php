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

// Route::middleware('auth:api')->get('/groupchats', function (Request $request) {
//     return $request->user();
// });

Route::get('/church/groupchats/{id}', [
    'as' => 'api.groupchats.church',
    'uses' => 'GroupchatsApiController@getByChurch'
]);

Route::get('/state/groupchats/{id}', [
    'as' => 'api.groupchats.state',
    'uses' => 'GroupchatsApiController@getByState'
]);