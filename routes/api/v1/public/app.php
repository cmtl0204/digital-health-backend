<?php

use App\Http\Controllers\V1\App\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\App\CatalogueController as AppCatalogueController;
use App\Http\Controllers\V1\Core\CatalogueController as CoreCatalogueController;

/***********************************************************************************************************************
 * APP CATALOGUES
 **********************************************************************************************************************/
Route::controller(AppCatalogueController::class)->group(function () {
    Route::prefix('app-catalogues/{catalogue}')->group(function () {

    });

    Route::prefix('app-catalogues')->group(function () {
        Route::get('catalogue', 'catalogue');
    });
});

/***********************************************************************************************************************
 * APP CATALOGUES
 **********************************************************************************************************************/
Route::controller(CoreCatalogueController::class)->group(function () {
    Route::prefix('core-catalogues/{catalogue}')->group(function () {

    });

    Route::prefix('core-catalogues')->group(function () {
        Route::get('catalogue', 'catalogue');
    });
});

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

