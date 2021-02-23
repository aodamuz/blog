<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Roles and Permissions
    |--------------------------------------------------------------------------
    |
    | Here you set the permissions that are created when
    | installingthe application, or when running the command:
    | "php artisan migrate:fresh --seed" or the command: "php artisan db:seed".
    |
    */

    'roles' => [
        [
            'title'       => 'User',
            'slug'        => 'user',
            'description' => 'System user',
            'removable'   => false,
        ],

        [
            'title'       => 'Administrator',
            'slug'        => 'admin',
            'description' => 'System administrator',
            'removable'   => false,
        ],

        [
            'title'       => 'Global administrator',
            'slug'        => 'global',
            'description' => 'Global system administrator',
            'removable'   => false,
        ],
    ],

    'resources' => [
        'categories',
        'posts',
        'tags',
        'users',
    ],

];
