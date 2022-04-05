<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\App\CatalogueController;

/***********************************************************************************************************************
 * CATALOGUES
 **********************************************************************************************************************/
Route::controller(CatalogueController::class)->group(function () {
    Route::prefix('catalogues/{catalogue}')->group(function () {

    });

    Route::prefix('catalogues')->group(function () {
        Route::get('catalogue', 'catalogue');
    });
});

Route::apiResource('catalogues', CatalogueController::class);
