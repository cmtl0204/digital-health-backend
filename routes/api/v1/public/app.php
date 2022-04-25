<?php

use App\Http\Controllers\V1\App\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\App\CatalogueController;

/***********************************************************************************************************************
 * CATALOGUES
 **********************************************************************************************************************/
Route::controller(CatalogueController::class)->group(function () {
    Route::prefix('app-catalogues/{catalogue}')->group(function () {

    });

    Route::prefix('app-catalogues')->group(function () {
        Route::get('catalogue', 'catalogue');
    });
});

Route::apiResource('app-catalogues', CatalogueController::class);

