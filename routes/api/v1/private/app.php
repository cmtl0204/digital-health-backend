<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\App\CatalogueController;
use App\Http\Controllers\V1\App\PatientController;
use App\Http\Controllers\V1\App\ClinicalHistoryController;

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
Route::controller(PatientController::class)->group(function () {
    Route::prefix('patients/{patient}')->group(function () {
        Route::post('clinical-histories','storeClinicalHistory');
        Route::put('clinical-histories/{clinical_history}','updateClinicalHistory');
        Route::get('clinical-histories/last','showLastClinicalHistory');
        Route::get('clinical-histories/results','showResultsLastClinicalHistory');
        Route::get('clinical-histories','getClinicalHistories');
        Route::put('users','updatePatientUser');
    });

    Route::prefix('patients')->group(function () {

    });
});

Route::apiResource('patients', PatientController::class);

Route::controller(ClinicalHistoryController::class)->group(function () {
    Route::prefix('clinical-histories/{clinical_history}')->group(function () {
        Route::put('patients/{patient}','update');
    });

    Route::prefix('clinical-histories')->group(function () {
        Route::get('patients/{patient}','indexByPatient');
        Route::get('patients/{patient}/last','showLastByPatient');
        Route::post('patients/{patient}','store');
    });
});

Route::apiResource('clinical-histories', ClinicalHistoryController::class);

