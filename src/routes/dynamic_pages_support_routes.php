<?php

use Illuminate\Support\Facades\Route;
use Otas\DynamicPages\Http\Controllers\Support\PageController;
use Otas\DynamicPages\Http\Controllers\Support\SectionController;
use Otas\DynamicPages\Http\Controllers\Support\SectionCustomAttributeController;
use Otas\DynamicPages\Http\Controllers\Support\SectionItemController;
use Otas\DynamicPages\Http\Controllers\Support\SectionItemCustomAttributeController;
use Otas\DynamicPages\Http\Controllers\Support\SectionItemMediaController;
use Otas\DynamicPages\Http\Controllers\Support\SectionMediaController;

Route::group([
    'as' => 'support.',
    'prefix' => config('dynamic_pages.package_support_routes_prefix'),
    'middleware' => array_unique(array_merge(config('dynamic_pages.middlewares.support'), [
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ])),
], function () {
    Route::apiResource('pages', PageController::class);

    Route::apiResource('pages.sections', SectionController::class)->scoped();
    Route::apiResource('sections.medias', SectionMediaController::class)->only(['store','destroy'])->scoped();

    Route::apiResource('pages.sections.custom-attributes', SectionCustomAttributeController::class)->scoped();

    Route::apiResource('pages.sections.section-items', SectionItemController::class)->scoped();
    Route::apiResource('section-items.medias', SectionItemMediaController::class)->only(['store','destroy'])->scoped();

    Route::apiResource('pages.sections.section-items.custom-attributes', SectionItemCustomAttributeController::class)->scoped();
});
