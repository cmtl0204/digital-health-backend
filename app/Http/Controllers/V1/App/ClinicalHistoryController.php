<?php

namespace App\Http\Controllers\V1\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\Catalogues\IndexCatalogueRequest;
use App\Http\Resources\V1\App\ClinicalHistories\ClinicalHistoryCollection;
use App\Http\Resources\V1\App\ClinicalHistories\ClinicalHistoryResource;
use App\Http\Resources\V1\App\Patients\PatientResource;
use App\Http\Resources\V1\App\UserPatients\UserPatientResource;
use App\Http\Resources\V1\Core\Users\UserResource;
use App\Models\App\ClinicalHistory;
use App\Models\App\Patient;
use App\Models\Authentication\User;
use App\Models\Core\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicalHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:update-patients')->only(['updatePatientUser']);
        $this->middleware('permission:view-patients')->only(['index']);
        $this->middleware('permission:delete-patients')->only(['destroy']);
//        $this->middleware('permission:store-clinicalHistories')->only(['storeClinicalHistory']);
        $this->middleware('permission:update-clinicalHistories')->only(['updateClinicalHistory']);
        $this->middleware('permission:view-clinicalHistories')->only(['getClinicalHistories']);
    }

    public function indexByPatient(Request $request, Patient $patient)
    {
        $clinicalHistories = $patient->clinicalHistories()
            ->orderBy('registered_at')
            ->paginate();

        return (new ClinicalHistoryCollection($clinicalHistories))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function show(ClinicalHistory $clinicalHistory)
    {
        return (new ClinicalHistoryResource($clinicalHistory))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function showLastByPatient(Patient $patient)
    {
        $clinicalHistory = $patient->clinicalHistories()
            ->orderByDesc('registered_at')
            ->first();

        return (new ClinicalHistoryResource($clinicalHistory))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function store(Request $request, Patient $patient)
    {
        $clinicalHistory = new ClinicalHistory();
        $clinicalHistory->patient()->associate($patient);
        $clinicalHistory->basal_metabolic_rate = $request->input('basalMetabolicRate');
        $clinicalHistory->blood_pressure = $request->input('bloodPressure');
        $clinicalHistory->breathing_frequency = $request->input('breathingFrequency');
        $clinicalHistory->glucose = $request->input('glucose');
        $clinicalHistory->hdl_cholesterol = $request->input('hdlCholesterol');
        $clinicalHistory->heart_rate = $request->input('heartRate');
        $clinicalHistory->height = $request->input('height');
        $clinicalHistory->is_smoke = $request->input('isSmoke');
        $clinicalHistory->is_diabetes = $request->input('isDiabetes');
        $clinicalHistory->ldl_cholesterol = $request->input('ldlCholesterol');
        $clinicalHistory->metabolic_age = $request->input('metabolicAge');
        $clinicalHistory->neck_circumference = $request->input('neckCircumference');
        $clinicalHistory->percentage_body_fat = $request->input('percentageBodyFat');
        $clinicalHistory->muscle_mass = $request->input('muscleMass');
        $clinicalHistory->percentage_body_water = $request->input('percentageBodyWater');
        $clinicalHistory->bone_mass = $request->input('boneMass');
        $clinicalHistory->percentage_visceral_fat = $request->input('percentageVisceralFat');
//        $clinicalHistory->registered_at = $request->input('registeredAt');
        $clinicalHistory->registered_at = now();
        $clinicalHistory->total_cholesterol = $request->input('totalCholesterol');
        $clinicalHistory->waist_circumference = $request->input('waistCircumference');
        $clinicalHistory->weight = $request->input('weight');
        $clinicalHistory->save();

        return (new ClinicalHistoryResource($clinicalHistory))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function update(Request $request, ClinicalHistory $clinicalHistory, Patient $patient)
    {
        $patient->save();
        $clinicalHistory->patient()->associate($patient);
        $clinicalHistory->basal_metabolic_rate = $request->input('basalMetabolicRate');
        $clinicalHistory->blood_pressure = $request->input('bloodPressure');
        $clinicalHistory->breathing_frequency = $request->input('breathingFrequency');
        $clinicalHistory->glucose = $request->input('glucose');
        $clinicalHistory->hdl_cholesterol = $request->input('hdlCholesterol');
        $clinicalHistory->heart_rate = $request->input('heartRate');
        $clinicalHistory->height = $request->input('height');
        $clinicalHistory->is_smoke = $request->input('isSmoke');
        $clinicalHistory->is_diabetes = $request->input('isDiabetes');
        $clinicalHistory->ldl_cholesterol = $request->input('ldlCholesterol');
        $clinicalHistory->metabolic_age = $request->input('metabolicAge');
        $clinicalHistory->neck_circumference = $request->input('neckCircumference');
        $clinicalHistory->percentage_body_fat = $request->input('percentageBodyFat');
        $clinicalHistory->muscle_mass = $request->input('muscleMass');
        $clinicalHistory->percentage_body_water = $request->input('percentageBodyWater');
        $clinicalHistory->bone_mass = $request->input('boneMass');
        $clinicalHistory->percentage_visceral_fat = $request->input('percentageVisceralFat');
//        $clinicalHistory->registered_at = $request->input('registeredAt');
        $clinicalHistory->registered_at = now();
        $clinicalHistory->total_cholesterol = $request->input('totalCholesterol');
        $clinicalHistory->waist_circumference = $request->input('waistCircumference');
        $clinicalHistory->weight = $request->input('weight');
        $clinicalHistory->save();

        return (new ClinicalHistoryResource($clinicalHistory))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }
}
