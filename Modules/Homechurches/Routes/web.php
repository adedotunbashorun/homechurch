<?php

Route::bind('homechurch', function ($id) {
    return app(Modules\Homechurches\Repositories\HomechurchInterface::class)->byId($id);
});
Route::group(['prefix' => 'admin'], function()
{
    Route::group(['prefix' => 'homechurches'], function () {
        Route::get('/', [
            'as' => 'admin.homechurches.index',
            'uses' => 'HomechurchesController@index'
        ]);
        Route::get('/submitted', [
            'as' => 'admin.homechurches.submittedHomechurches',
            'uses' => 'HomechurchesController@submittedHomechurches'
        ]);
        Route::get('{id}/approved', [
            'as' => 'admin.homechurches.approveSubmittedHomechurches',
            'uses' => 'HomechurchesController@approveSubmittedHomechurches'
        ]);
        Route::get('create', [
            'as' => 'admin.homechurches.create',
            'uses' => 'HomechurchesController@create'
        ]);
        Route::get('{homechurch}/edit', [
            'as' => 'admin.homechurches.edit',
            'uses' => 'HomechurchesController@edit'
        ]);
        Route::get('church/{id}', [
            'as' => 'admin.homechurches.getByChurch',
            'uses' => 'HomechurchesController@getByChurch'
        ]);
        Route::post('/', [
            'as' => 'admin.homechurches.store',
            'uses' => 'HomechurchesController@store'
        ]);
        Route::put('{homechurch}', [
            'as' => 'admin.homechurches.update',
            'uses' => 'HomechurchesController@update'
        ]);
        Route::get('data/table', [
            'as' => 'admin.homechurches.datatable',
            'uses' => 'HomechurchesController@dataTable'
        ]);
        Route::delete('{homechurch}', [
            'as' => 'admin.homechurches.destroy',
            'uses' => 'HomechurchesController@destroy'
        ]);
    });
});
