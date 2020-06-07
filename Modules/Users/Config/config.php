<?php

return [
    'name' => 'Users',
    'driver' => 'Sentinel',
    'order' => [
        'id' => 'asc',
    ],
    'sidebar' => [
        'weight' => 2,
    ],
    'th' => ['first_name', 'last_name', 'email','created_at'],
    'columns' => [
        ['data' => 'first_name', 'name' => 'first_name'],
        ['data' => 'last_name', 'name' => 'last_name'],
        ['data' => 'email', 'name' => 'email'],
        /*['data' => 'username', 'name' => 'username'],*/
        ['data' => 'created_at', 'name' => 'created_at'],
        ['data' => 'action', 'name' => 'action'],
    ],
    'form' => 'Users\Forms\UsersForm',

    'roles' => [
        'th' => ['name', 'slug'],
        'form' => 'Users\Forms\RolesForm',
    ],

    'permissions' => [
        'users' => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
        'users.roles' => [
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ],
    ],

    /*
   |--------------------------------------------------------------------------
   | Define which route to redirect to after a successful login
   |--------------------------------------------------------------------------
   */
    'redirect_route_after_login' => 'homepage',
    /*
    |--------------------------------------------------------------------------
    | Login column(s)
    |--------------------------------------------------------------------------
    | Define which column(s) you'd like to use to login with, currently
    | only supported by the Sentinel user driver
    */
    'login-columns' => ['email','username'],
    /*
    |--------------------------------------------------------------------------
    | Allow anonymous user registration
    |--------------------------------------------------------------------------
    */
    'allow_user_registration' => true,
    /*
    |--------------------------------------------------------------------------
    | Fillable user fields
    |--------------------------------------------------------------------------
    | Set the fillable user fields, those fields will be mass assigned
    */
    'fillable' => [
        'email',
        'password',
        'permissions',
        'first_name',
        'last_name',
        'phone',
        'address',
        'avatar',
        'username',
        'homechurch_group',
        'state_id',
        'country_id',
        'church_id',
        'birthday',
        'age',
        'gender'
    ],
];
