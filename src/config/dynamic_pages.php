<?php

return [
    /*
    |--------------------------------------------------------------------------
    | dynamic_pages Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the options for the Otas dynamic_pages package.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Package routes prefix
    |--------------------------------------------------------------------------
    |
    | Here you may prefer to union the usage of your project routes with a global
    | prefix. Define this preferred prefix and access package predefined
    | routes under the same project global prefix to union the output
    | of your apis.
    |
    */
    'package_routes_prefix' => 'api',

    /*
    |--------------------------------------------------------------------------
    | Admin routes prefix
    |--------------------------------------------------------------------------
    |
    | Here you may prefer to specify an additional prefix to separate admin routes under
    | specific prefix. Define this preferred prefix here.
    |
    */
    'package_admin_routes_prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Support routes prefix
    |--------------------------------------------------------------------------
    |
    | Here you may prefer to specify an additional prefix to separate support routes under
    | specific prefix. Define this preferred prefix here.
    |
    */
    'package_support_routes_prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Website routes prefix
    |--------------------------------------------------------------------------
    |
    | Here you may prefer to specify an additional prefix to separate website routes under
    | specific prefix. Define this preferred prefix here.
    |
    */
    'package_website_routes_prefix' => '',

    /*
    | --------------------------------------------------------------------------
    | Route files middlewares
    | --------------------------------------------------------------------------
    |
    | Here you may specify the middlewares that should be applied to the
    | package routes. You can define different middlewares for admin, support, and website routes.
    | This allows you to customize the behavior of the routes based on the context in which they are accessed.
    |
     */
    'middlewares' => [
        'admin' => [
            //
        ],
        'support' => [
            //
        ],
        'website' => [
            //
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes publish subdirectory
    |--------------------------------------------------------------------------
    |
    | Here you may specify the subdirectory where the package routes should be
    | published inside the project's routes folder. This allows you to customize the location of the published
    | routes files.
    |
    */
    # eg: 'routes_publish_subdirectory' => 'custom/',
    'routes_publish_subdirectory' => '',

    /*
    |--------------------------------------------------------------------------
    | Load Routes
    |--------------------------------------------------------------------------
    |
    | This option controls whether the package routes should be loaded.
    | Set this value to true to load the routes, or false to disable them.
    |
    */
    'load_routes' => true,
];
