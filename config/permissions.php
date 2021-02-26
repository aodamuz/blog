<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Access Key
    |--------------------------------------------------------------------------
    |
    | Key used for permission to access the administration panel.
    | This key is used in the permissions and in the
    | App\Http\Middleware\AccessMiddleware class.
    |
    */

    'access_key' => 'access',

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
            'title' => 'User',
            'description' => 'System user.',
            'removable' => false,
        ],

        [
            'title' => 'Administrator',
            'slug' => 'admin',
            'description' => 'System administrator.',
            'removable' => false,
        ],

        [
            'title' => 'Global Administrator',
            'slug' => 'global',
            'description' => 'Global system administrator.',
            'removable' => false,
        ],

        [
            'title' => 'Author',
            'description' => 'Post writer.',
            'removable' => false,
        ],
    ],

    'permissions' => [

        'posts' => [
            [
                'title' => 'Post Manager',
                'description' => 'Permission to manage posts.',
            ],

            [
                'title' => 'View Posts',
                'description' => 'Permission to see the list of posts.',
            ],

            [
                'title' => 'Create Posts',
                'description' => 'Permission to create posts.',
            ],

            [
                'title' => 'Edit Posts',
                'description' => 'Permission to edit posts.',
            ],

            [
                'title' => 'Delete Posts',
                'description' => 'Permission to delete posts.',
            ],

            [
                'title' => 'Moderator',
                'description' => 'Permission to moderate comments on posts.',
            ],
        ],

        'categories' => [
            [
                'title' => 'Category Manager',
                'description' => 'Permission to manage categories.',
            ],

            [
                'title' => 'View Categories',
                'description' => 'Permission to see the list of categories.',
            ],

            [
                'title' => 'Create Categories',
                'description' => 'Permission to create categories.',
            ],

            [
                'title' => 'Edit Categories',
                'description' => 'Permission to edit categories.',
            ],

            [
                'title' => 'Delete Categories',
                'description' => 'Permission to delete categories.',
            ],
        ],

        'tags' => [
            [
                'title' => 'Tag Manager',
                'description' => 'Permission to manage tags.',
            ],

            [
                'title' => 'View Tags',
                'description' => 'Permission to see the list of tags.',
            ],

            [
                'title' => 'Create Tags',
                'description' => 'Permission to create tags.',
            ],

            [
                'title' => 'Edit Tags',
                'description' => 'Permission to edit tags.',
            ],

            [
                'title' => 'Delete Tags',
                'description' => 'Permission to delete tags.',
            ],
        ],

        'users' => [
            [
                'title' => 'User Manager',
                'description' => 'Permission to manage users.',
            ],

            [
                'title' => 'View Users',
                'description' => 'Permission to see the list of users.',
            ],

            [
                'title' => 'Create Users',
                'description' => 'Permission to create users.',
            ],

            [
                'title' => 'Edit Users',
                'description' => 'Permission to edit users.',
            ],

            [
                'title' => 'Delete Users',
                'description' => 'Permission to delete users.',
            ],
        ],
    ],

];
