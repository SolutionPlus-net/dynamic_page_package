<?php

use Illuminate\Support\Facades\Route;
use Otas\DynamicPages\Http\Controllers\Admin\KeywordController;
use Otas\DynamicPages\Http\Controllers\Admin\PageController;
use Otas\DynamicPages\Http\Controllers\Admin\PageKeywordController;
use Otas\DynamicPages\Http\Controllers\Admin\SectionController;
use Otas\DynamicPages\Http\Controllers\Admin\SectionCustomAttributeController;
use Otas\DynamicPages\Http\Controllers\Admin\SectionItemController;
use Otas\DynamicPages\Http\Controllers\Admin\SectionItemCustomAttributeController;
use Otas\DynamicPages\Http\Controllers\Admin\SectionItemMediaController;
use Otas\DynamicPages\Http\Controllers\Admin\SectionMediaController;

Route::group([
    'as' => 'admin.',
    'prefix' => config('dynamic_pages.package_admin_routes_prefix'),
    'middleware' => array_unique(array_merge(config('dynamic_pages.middlewares.admin'), [
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ])),
], function () {
    Route::apiResource('pages', PageController::class)->except(['store', 'destroy']);
    Route::apiResource('keywords', KeywordController::class);
    Route::apiResource('pages.keywords', PageKeywordController::class)->only(['index', 'store'])->scoped();

    Route::apiResource('pages.sections', SectionController::class)->except(['store', 'destroy'])->scoped();
    Route::apiResource('sections.medias', SectionMediaController::class)->only(['store', 'destroy'])->scoped();

    Route::apiResource('pages.sections.custom-attributes', SectionCustomAttributeController::class)->except(['store', 'destroy'])->scoped();

    Route::apiResource('pages.sections.section-items', SectionItemController::class)->except(['store', 'destroy'])->scoped();
    Route::apiResource('section-items.medias', SectionItemMediaController::class)->only(['store', 'destroy'])->scoped();

    Route::apiResource('pages.sections.section-items.custom-attributes', SectionItemCustomAttributeController::class)->except(['store', 'destroy'])->scoped();
});
