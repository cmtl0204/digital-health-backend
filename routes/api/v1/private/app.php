<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\App\CatalogueController;
use App\Http\Controllers\V1\App\PatientController;

/***********************************************************************************************************************
 * CATALOGUES
 **********************************************************************************************************************/
Route::controller(CatalogueController::class)->group(function () {
    Route::prefix('catalogues/{catalogue}')->group(function () {

    });

    Route::prefix('catalogues')->group(function () {

    });
});

Route::apiResource('catalogues', CatalogueController::class);

/***********************************************************************************************************************
 * PATIENTS
 **********************************************************************************************************************/
//Route::controller(PatientController::class)->group(function () {
//    Route::prefix('patients/{patient}')->group(function () {
//        Route::post('clinical-histories','storeClinicalHistory');
//        Route::put('clinical-histories/{clinical_history}','updateClinicalHistory');
//        Route::get('clinical-histories','getClinicalHistories');
//        Route::put('users','updatePatientUser');
//    });
//
//    Route::prefix('patients')->group(function () {
//
//    });
//});

Route::apiResource('patients', PatientController::class);

