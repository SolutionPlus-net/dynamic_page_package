<?php

use Illuminate\Support\Facades\Route;
use Otas\DynamicPages\Http\Controllers\Website\PageController;

Route::group([
    'as' => 'website.',
    'prefix' => config('dynamic_pages.package_website_routes_prefix'),
    'middleware' => array_unique(array_merge(config('dynamic_pages.middlewares.website'), [
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ])),
], function () {
    Route::apiResource('pages', PageController::class, ['only' => ['index', 'show']]);
});
