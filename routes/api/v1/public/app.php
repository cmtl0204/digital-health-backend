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

/***********************************************************************************************************************
 * PATIENTS
 **********************************************************************************************************************/
Route::controller(PatientController::class)->group(function () {
    Route::prefix('patients/{patient}')->group(function () {

    });

    Route::prefix('patients')->group(function () {
        Route::post('users','registerPatientUser');
    });
});

