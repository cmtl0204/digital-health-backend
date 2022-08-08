<?php

use App\Http\Controllers\V1\Authentication\AuthController;
use App\Models\App\Product;
use App\Models\App\TreatmentOption;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('login')->group(function () {
    Route::get('{driver}', [AuthController::class, 'redirectToProvider']);
    Route::get('{driver}/callback', [AuthController::class, 'handleProviderCallback']);
});

Route::get('generate-password/{password}', function ($password) {
    return \Illuminate\Support\Facades\Hash::make($password);
});

Route::get('terms-conditions', function () {
    return Storage::download('files/terms_conditions.pdf');
});

Route::get('options', function () {
    $treatmentDetails = \App\Models\App\TreatmentDetail::get();

    foreach ($treatmentDetails as $treatmentDetail) {
        $product = $treatmentDetail->product()->first();
         $type = $product->type()->first();

        $products = $type->products()->get();

        foreach ($products as $product) {
            $treatmentOption = new TreatmentOption();
            $treatmentOption->treatmentDetail()->associate($treatmentDetail);
            $treatmentOption->product()->associate(Product::find($product->id));
            $treatmentOption->unit = $product->unit;
            $treatmentOption->quantity = $product->quantity;
            $treatmentOption->save();
        }

    }

});
