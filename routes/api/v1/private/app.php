<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\App\CatalogueController;
use App\Http\Controllers\V1\App\PatientController;
use App\Http\Controllers\V1\App\ClinicalHistoryController;
use App\Http\Controllers\V1\App\TreatmentController;
use App\Http\Controllers\V1\App\ProductController;

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
        Route::get('profile','profile');
        Route::put('users','updatePatientUser');
    });

    Route::prefix('patients')->group(function () {

    });
});

Route::apiResource('patients', PatientController::class);

/***********************************************************************************************************************
 * CLINICAL HISTORIES
 **********************************************************************************************************************/
Route::controller(ClinicalHistoryController::class)->group(function () {
    Route::prefix('clinical-histories/{clinical_history}')->group(function () {
        Route::put('patients/{patient}','update');
        Route::get('patients/{patient}','getByPatient');
    });

    Route::prefix('clinical-histories')->group(function () {
        Route::get('patients/{patient}','indexByPatient');
        Route::get('patients/{patient}/last','showLastByPatient');
        Route::post('patients/{patient}','store');
    });
});

Route::apiResource('clinical-histories', ClinicalHistoryController::class);

/***********************************************************************************************************************
 * TREATMENTS
 **********************************************************************************************************************/
Route::controller(TreatmentController::class)->group(function () {
    Route::prefix('treatments/{treatment}')->group(function () {
        Route::post('treatment-details','storeTreatmentDetail');
        Route::get('treatment-details','getTreatmentDetails');
        Route::get('treatment-details-mobile','getTreatmentDetailsMobile');
        Route::get('reports','generateReport');
    });

    Route::prefix('treatments')->group(function () {
        Route::get('patients/{patient}/last','getLastByPatient');
        Route::post('patients/{patient}','store');
        Route::put('treatment-details/{treatment_detail}','updateTreatmentDetail');
        Route::delete('treatment-details/{treatment_detail}','destroyTreatmentDetail');
        Route::put('treatment-details','updateTreatmentDetails');
    });
});

Route::apiResource('treatments', TreatmentController::class);

/***********************************************************************************************************************
 * PRODUCTS
 **********************************************************************************************************************/
Route::controller(ProductController::class)->group(function () {
    Route::prefix('products/{product}')->group(function () {
        Route::put('patients/{patient}','update');
        Route::get('patients/{patient}','getByPatient');
    });

    Route::prefix('products')->group(function () {
        Route::get('catalogue','catalogue');
    });
});

Route::apiResource('products', ProductController::class);
