<?php

namespace Modules\Users\Providers;

use Config;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Modules\Users\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        /*Route::model('user', config('auth.providers.users.model'));*/
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::group(['namespace' => $this->namespace], function () {

            Route::group(['prefix' => 'account','middleware'=>config('myapp.middleware.account')], function ()
            {
                Route::get('profile', ['as' => 'profile.index', 'uses' => 'UsersAccountController@index']);
                Route::post('profile/update', ['as' => 'profile.update', 'uses' => 'UsersAccountController@update']);
                Route::post('change-password', array('as' => 'profile.change-password.post', 'uses' => 'UsersAccountController@postChangePassword'));
                Route::get('change-password', array('as' => 'profile.change-password', 'uses' => 'UsersAccountController@getChangePassword'));
                Route::get('resend-activation', array('as' => 'profile.resend_activation', 'uses' => 'UsersPublicController@resendActivation'));
            });

            Route::group(['prefix' => 'api','middleware'=>config('myapp.middleware.api')], function ()
            {
                Route::post('auth/register', ['as' => 'api.user.register', 'uses' => 'UsersApiController@register']);
            });

            Route::group(['prefix' => 'auth'], function () {
                Route::get('login', ['middleware' => 'web', 'as' => 'login', 'uses' => 'AuthController@getLogin']);
                Route::post('login', ['as' => 'login.post', 'uses' => 'AuthController@postLogin']);
                # Register

                Route::post('register', ['as' => 'register.post', 'uses' => 'AuthController@postRegister']);

                // facebook login
                Route::get('login/facebook', ['as' => 'facebook.register', 'uses' => 'AuthController@redirectToFacebook'] );
                Route::get('login/callback', 'Auth\AuthController@getFacebookCallback');

                # Account Activation
                Route::get('activate/{userId}/{activationCode}', 'AuthController@getActivate');
                # Reset password
                Route::get('reset', ['as' => 'reset', 'uses' => 'AuthController@getReset']);
                Route::post('reset', ['as' => 'reset.post', 'uses' => 'AuthController@postReset']);
                Route::get('reset/{id}/{code}', ['as' => 'reset.complete', 'uses' => 'AuthController@getResetComplete']);
                Route::post('reset/{id}/{code}', ['as' => 'reset.complete.post', 'uses' => 'AuthController@postResetComplete']);
                # Logout
                Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);
            });


            Route::get('admin/users/change-password', array('as' => 'admin.users.change-password', 'uses' => 'UsersController@changePassword'));
            Route::post('admin/users/change-password', array('as' => 'admin.users.change-password.post', 'uses' => 'UsersController@postChangePassword'));


            Route::get('admin/users', ['as' => 'admin.users.index', 'uses' => 'UsersController@index']);
            Route::get('admin/users/members', ['as' => 'admin.users.members', 'uses' => 'UsersController@index']);
            Route::get('admin/users/datatable', ['as' => 'admin.users.datatable', 'uses' => 'UsersController@dataTable']);
            Route::get('admin/users/create', ['as' => 'admin.users.create', 'uses' => 'UsersController@create']);
            Route::get('admin/users/{user}/edit', ['as' => 'admin.users.edit', 'uses' => 'UsersController@edit']);
            Route::post('admin/users', ['as' => 'admin.users.store', 'uses' => 'UsersController@store']);
            Route::put('admin/users/{user}', ['as' => 'admin.users.update', 'uses' => 'UsersController@update']);
            Route::post('admin/users/sort', ['as' => 'admin.users.sort', 'uses' => 'UsersController@sort']);

            /*
             * Ajax routes
             */
            Route::get('ajax/users', ['as' => 'ajax.users.index', 'uses' => 'UsersAjaxController@index']);
            Route::put('ajax/users/{user}', ['as' => 'ajax.users.update', 'uses' => 'UsersAjaxController@update']);
            Route::delete('ajax/users/{user}', ['as' => 'ajax.users.destroy', 'uses' => 'UsersAjaxController@destroy']);

            //Roles
            Route::get('admin/roles', ['as' => 'admin.users.roles.index', 'uses' => 'RolesController@index']);
            Route::get('admin/roles/create', ['as' => 'admin.users.roles.create', 'uses' => 'RolesController@create']);
            Route::post('admin/roles', ['as' => 'admin.users.roles.store', 'uses' => 'RolesController@store']);
            Route::get('admin/roles/{roles}/edit', ['as' => 'admin.users.roles.edit', 'uses' => 'RolesController@edit']);
            Route::put('admin/roles/{roles}/edit', ['as' => 'admin.users.roles.update', 'uses' => 'RolesController@update']);

            Route::get('ajax/roles', ['as' => 'ajax.users.roles.index', 'uses' => 'RolesAjaxController@index']);
            Route::put('ajax/roles/{role}', ['as' => 'ajax.users.roles.update', 'uses' => 'RolesAjaxController@update']);
            Route::delete('ajax/roles/{role}', ['as' => 'ajax.users.roles.destroy', 'uses' => 'RolesAjaxController@destroy']);

        });
    }
}
