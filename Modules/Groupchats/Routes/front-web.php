<?php

use Illuminate\Support\Facades\Route;

// if ($page = \MyApp::getPageLinkedToModule('groupchats')) {
//     $options = [];
//     if ($uri = $page->uri) {
//         // dd($page);
//         Route::get($uri, $options + ['as' => 'groupchats', 'uses' => 'GroupchatsPublicController@index']);
//         Route::get($uri.'/{slug}', $options +  ['as' => 'groupchats.slug', 'uses' => 'GroupchatsPublicController@show']);
//     }
// }

/*Route::group(['prefix' => 'groupchats'], function()
{
    Route::get('/', 'GroupchatsPublicController@index');
});*/

Route::group(['prefix' => 'groupchats'], function()
{
    Route::get('/', 'GroupchatsPublicController@index')->name('groupchats');
    Route::post('/store', 'GroupchatsPublicController@store');
    Route::post('/add/user','GroupchatsPublicController@addUser');
});

Route::group(['prefix' => 'conversations'], function()
{
    Route::post('/store', 'ConversationController@store');
    Route::get('/{id}', 'ConversationController@get');
});