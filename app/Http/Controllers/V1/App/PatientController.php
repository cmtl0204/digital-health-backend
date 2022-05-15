<?php

namespace App\Http\Controllers\V1\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\Catalogues\IndexCatalogueRequest;
use App\Http\Requests\V1\App\ClinicalHistories\StoreClinicalHistoryRequest;
use App\Http\Requests\V1\App\ClinicalHistories\UpdateClinicalHistoryRequest;
use App\Http\Requests\V1\App\Patients\RegisterPatientUserRequest;
use App\Http\Requests\V1\App\Patients\UpdatePatientUserRequest;
use App\Http\Resources\V1\App\ClinicalHistories\ClinicalHistoryResource;
use App\Http\Resources\V1\App\Patients\PatientResource;
use App\Http\Resources\V1\App\Patients\ProfileResource;
use App\Http\Resources\V1\App\UserPatients\UserPatientCollection;
use App\Http\Resources\V1\App\UserPatients\UserPatientResource;
use App\Models\App\ClinicalHistory;
use App\Models\App\FraminghamTable;
use App\Models\App\Patient;
use App\Models\App\ReferenceValue;
use App\Models\App\Risk;
use App\Models\Authentication\User;
use App\Models\Core\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
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

    public function index(IndexCatalogueRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $catalogues = Catalogue::customOrderBy($sorts)
            ->type($request->input('type'))
            ->paginate($request->input('perPage'));

        return (new UserPatientCollection($catalogues))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    public function registerPatientUser(RegisterPatientUserRequest $request)
    {
        $user = new User();
        $user->gender()->associate(Catalogue::find($request->input('gender.id')));
        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->birthdate = $request->input('birthdate');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');


        $patient = new Patient();
        $patient->sector()->associate(Catalogue::find($request->input('sector.id')));

        DB::transaction(function () use ($request, $user, $patient) {
            $user->save();
            $patient->user()->associate($user);
            $patient->save();
            $user->assignRole('patient');
        });

        return (new UserPatientResource($user))
            ->additional([
                'msg' => [
                    'summary' => 'Cuenta Creada',
                    'detail' => 'La cuenta se creó correctamente',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function updatePatientUser(UpdatePatientUserRequest $request, Patient $patient)
    {
        $user = $patient->user()->first();
        $user->gender()->associate(Catalogue::find($request->input('gender.id')));
        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->birthdate = $request->input('birthdate');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        $patient->sector()->associate(Catalogue::find($request->input('sector.id')));

        DB::transaction(function () use ($request, $user, $patient) {
            $user->save();
            $patient->save();
        });

        return (new ProfileResource($patient))
            ->additional([
                'msg' => [
                    'summary' => 'Paciente actualizado',
                    'detail' => 'Se actualizó correctamente',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function show(Patient $patient)
    {
        return (new PatientResource($patient))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function profile(Patient $patient)
    {
        return (new ProfileResource($patient))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }

    public function showResultsLastClinicalHistory(Patient $patient)
    {
        $user = $patient->user()->with('gender')->first();

        $clinicalHistory = $patient->clinicalHistories()
            ->orderByDesc('registered_at')
            ->first();

        $boneMass = $this->calculateBoneMass($user, $clinicalHistory);
        $breathingFrequency = $this->calculateBreathingFrequency($user, $clinicalHistory);
        $diastolic = $this->calculateDiastolic($user, $clinicalHistory);
        $glucose = $this->calculateGlucose($clinicalHistory);
        $hdlCholesterol = $this->calculateHdlCholesterol($clinicalHistory);
        $heartRate = $this->calculateHeartRate($user, $clinicalHistory);
        $iceScore = $this->calculateIceScore($clinicalHistory);
        $ldlCholesterol = $this->calculateLdlCholesterol($clinicalHistory);
        $muscleMass = $this->calculateMuscleMass($user, $clinicalHistory);
        $neckCircumference = $this->calculateNeckCircumferenceScore($user, $clinicalHistory);
        $percentageBodyFat = $this->calculatePercentageBodyFat($user, $clinicalHistory);
        $percentageBodyWater = $this->calculatePercentageBodyWater($user, $clinicalHistory);
        $percentageVisceralFat = $this->calculatePercentageVisceralFat($user, $clinicalHistory);
        $risk = $this->calculateRisk($user, $clinicalHistory);
        $systolic = $this->calculateSystolic($user, $clinicalHistory);
        $totalCholesterol = $this->calculateTotalCholesterol($clinicalHistory);

        $data = array(
            'bodyFat' => $percentageBodyFat,
            'boneMass' => $boneMass,
            'breathingFrequency' => $breathingFrequency,
            'diastolic' => $diastolic,
            'glucose' => $glucose,
            'hdlCholesterol' => $hdlCholesterol,
            'heartRate' => $heartRate,
            'ice' => $iceScore,
            'ldlCholesterol' => $ldlCholesterol,
            'muscleMass' => $muscleMass,
            'neckCircumference' => $neckCircumference,
            'percentageBodyWater' => $percentageBodyWater,
            'percentageVisceralFat' => $percentageVisceralFat,
            'registeredAt' => $clinicalHistory ? $clinicalHistory->registered_at : null,
            'isNew' => $clinicalHistory ? false : true,
            'risk' => $risk,
            'systolic' => $systolic,
            'totalCholesterol' => $totalCholesterol,
        );

        return response()->json([
            'data' => json_decode(json_encode($data)),
            'msg' => [
                'summary' => 'Paciente actualizado',
                'detail' => 'Se actualizó correctamente',
                'code' => '201'
            ]
        ]);
    }

    public function showLastClinicalHistory(Patient $patient)
    {
        $clinicalHistory = $patient->clinicalHistories()
            ->orderByDesc('registered_at')
            ->first();

        if (!isset($clinicalHistory)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No existe Historia Clínica',
                    'detail' => '',
                    'code' => '404'
                ]
            ], 404);
        }
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

    public function storeClinicalHistory(StoreClinicalHistoryRequest $request, Patient $patient)
    {
        $clinicalHistory = new ClinicalHistory();
        $clinicalHistory->patient()->associate($patient);
        $clinicalHistory->basal_metabolic_rate = $request->input('basalMetabolicRate');
        $clinicalHistory->bone_mass = $request->input('boneMass');
        $clinicalHistory->breathing_frequency = $request->input('breathingFrequency');
        $clinicalHistory->diastolic = $request->input('diastolic');
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
        $clinicalHistory->percentage_visceral_fat = $request->input('percentageVisceralFat');
        $clinicalHistory->systolic = $request->input('systolic');
        $clinicalHistory->registered_at = now();
        $clinicalHistory->total_cholesterol = $request->input('totalCholesterol');
        $clinicalHistory->waist_circumference = $request->input('waistCircumference');
        $clinicalHistory->weight = $request->input('weight');
        $clinicalHistory->save();

        return (new ClinicalHistoryResource($clinicalHistory))
            ->additional([
                'msg' => [
                    'summary' => 'Datos Creados',
                    'detail' => 'Los datos se crearon correctamente',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function updateClinicalHistory(UpdateClinicalHistoryRequest $request, Patient $patient, ClinicalHistory $clinicalHistory)
    {
        $patient->save();
        $clinicalHistory->patient()->associate($patient);
        $clinicalHistory->basal_metabolic_rate = $request->input('basalMetabolicRate');
        $clinicalHistory->breathing_frequency = $request->input('breathingFrequency');
        $clinicalHistory->diastolic = $request->input('diastolic');
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
//        $clinicalHistory->registered_at = now();
        $clinicalHistory->systolic = $request->input('systolic');
        $clinicalHistory->total_cholesterol = $request->input('totalCholesterol');
        $clinicalHistory->waist_circumference = $request->input('waistCircumference');
        $clinicalHistory->weight = $request->input('weight');
        $clinicalHistory->save();

        return (new ClinicalHistoryResource($clinicalHistory))
            ->additional([
                'msg' => [
                    'summary' => 'Datos Actualizados',
                    'detail' => 'Los datos se actualizaron correctamente',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    private function calculatePercentageBodyFat($user, $clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        if (isset($clinicalHistory->percentage_body_fat, $user->gender)) {
            $referenceValue = ReferenceValue::where('code', 'PBF')
                ->where('gender', $user->gender->code)
                ->where('age_min', '<=', $user->age)
                ->where('age_max', '>=', $user->age)
                ->where('value_min', '<=', $clinicalHistory->percentage_body_fat)
                ->where('value_max', '>=', $clinicalHistory->percentage_body_fat)
                ->first();
            $data = array(
                'level' => $referenceValue->level,
                'interpretation' => $referenceValue->interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculatePercentageBodyWater($user, $clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        if (isset($clinicalHistory->percentage_body_water, $user->gender)) {
            $referenceValue = ReferenceValue::where('code', 'PBW')
                ->where('gender', $user->gender->code)
                ->where('value_min', '<=', $clinicalHistory->percentage_body_water)
                ->where('value_max', '>=', $clinicalHistory->percentage_body_water)
                ->first();
            $data = array(
                'level' => $referenceValue->level,
                'interpretation' => $referenceValue->interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculatePercentageVisceralFat($user, $clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        if (isset($clinicalHistory->percentage_visceral_fat, $user->gender)) {
            $referenceValue = ReferenceValue::where('code', 'PVF')
                ->where('gender', $user->gender->code)
                ->where('value_min', '<=', $clinicalHistory->percentage_visceral_fat)
                ->where('value_max', '>=', $clinicalHistory->percentage_visceral_fat)
                ->first();
            $data = array(
                'level' => $referenceValue->level,
                'interpretation' => $referenceValue->interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateMuscleMass($user, $clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        if (isset($clinicalHistory->muscle_mass, $user->gender)) {
            $referenceValue = ReferenceValue::where('code', 'MM')
                ->where('gender', $user->gender->code)
                ->where('age_min', '<=', $user->age)
                ->where('age_max', '>=', $user->age)
                ->where('value_min', '<=', $clinicalHistory->muscle_mass)
                ->where('value_max', '>=', $clinicalHistory->muscle_mass)
                ->first();
            $data = array(
                'level' => $referenceValue->level,
                'interpretation' => $referenceValue->interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateBoneMass($user, $clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        if (isset($clinicalHistory->bone_mass, $user->gender)) {
            $referenceValue = ReferenceValue::where('code', 'BM')
                ->where('gender', $user->gender->code)
                ->where('weight_min', '<=', $clinicalHistory->weight)
                ->where('weight_max', '>=', $clinicalHistory->weight)
                ->where('value_min', '<=', $clinicalHistory->bone_mass)
                ->where('value_max', '>=', $clinicalHistory->bone_mass)
                ->first();
            $data = array(
                'level' => $referenceValue->level,
                'interpretation' => $referenceValue->interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateTotalCholesterol($clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        $interpretation = '';
        $level = null;

        if (isset($clinicalHistory->total_cholesterol)) {

            if ($clinicalHistory->total_cholesterol < 200) {
                $interpretation = 'Normal';
                $level = 2;
            }
            if ($clinicalHistory->total_cholesterol >= 200) {
                $interpretation = 'Alto';
                $level = 4;
            }

            $data = array(
                'level' => $level,
                'interpretation' => $interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateHdlCholesterol($clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        $interpretation = '';
        $level = null;

        if (isset($clinicalHistory->hdl_cholesterol)) {

            if ($clinicalHistory->hdl_cholesterol < 40) {
                $interpretation = 'Bajo';
                $level = 1;
            }
            if ($clinicalHistory->hdl_cholesterol >= 40) {
                $interpretation = 'Normal';
                $level = 2;
            }

            $data = array(
                'level' => $level,
                'interpretation' => $interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateLdlCholesterol($clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        $interpretation = '';
        $level = null;

        if (isset($clinicalHistory->ldl_cholesterol)) {
            if ($clinicalHistory->ldl_cholesterol < 100) {
                $interpretation = 'Óptimo';
                $level = 2;
            }

            if ($clinicalHistory->ldl_cholesterol >= 100 && $clinicalHistory->ldl_cholesterol <= 129) {
                $interpretation = 'Arriba del óptimo';
                $level = 2;
            }

            if ($clinicalHistory->ldl_cholesterol >= 130 && $clinicalHistory->ldl_cholesterol <= 159) {
                $interpretation = 'Fronterizo alto';
                $level = 4;
            }

            if ($clinicalHistory->ldl_cholesterol >= 160 && $clinicalHistory->ldl_cholesterol <= 189) {
                $interpretation = 'Alto';
                $level = 4;
            }

            if ($clinicalHistory->ldl_cholesterol >= 190) {
                $interpretation = 'Muy Alto';
                $level = 4;
            }

            $data = array(
                'level' => $level,
                'interpretation' => $interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateGlucose($clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        $interpretation = '';
        $level = null;

        if (isset($clinicalHistory->glucose)) {
            if ($clinicalHistory->glucose < 70) {
                $interpretation = 'Bajo';
                $level = 1;
            }
            if ($clinicalHistory->glucose >= 70 && $clinicalHistory->glucose < 100) {
                $interpretation = 'Normal';
                $level = 2;
            }
            if ($clinicalHistory->glucose >= 100 && $clinicalHistory->glucose < 125) {
                $interpretation = 'Prediabetes';
                $level = 3;
            }
            if ($clinicalHistory->glucose >= 126) {
                $interpretation = 'Diabetes';
                $level = 4;
            }

            $data = array(
                'level' => $level,
                'interpretation' => $interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateRisk($user, $clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        if (isset($user->age,
            $user->gender,
            $clinicalHistory->total_cholesterol,
            $clinicalHistory->hdl_cholesterol,
            $clinicalHistory->systolic,
            $clinicalHistory->is_diabetes,
            $clinicalHistory->is_smoke)) {
            $scoreAge = (FraminghamTable::where('code', 'AGE')
                ->where('gender', $user->gender->code)
                ->where('value_min', '<=', $user->age)
                ->where('value_max', '>=', $user->age)
                ->first())->score;

            $scoreTotalCholesterol = (FraminghamTable::where('code', 'CHOLESTEROL')
                ->where('gender', $user->gender->code)
                ->where('value_min', '<=', $clinicalHistory->total_cholesterol)
                ->where('value_max', '>=', $clinicalHistory->total_cholesterol)
                ->first())->score;

            $scoreHdlCholesterol = (FraminghamTable::where('code', 'HDL')
                ->where('gender', $user->gender->code)
                ->where('value_min', '<=', $clinicalHistory->hdl_cholesterol)
                ->where('value_max', '>=', $clinicalHistory->hdl_cholesterol)
                ->first())->score;

            $scoreSystolic = (FraminghamTable::where('code', 'SYSTOLIC')
                ->where('gender', $user->gender->code)
                ->where('value_min', '<=', $clinicalHistory->systolic)
                ->where('value_max', '>=', $clinicalHistory->systolic)
                ->first())->score;

            $scoreDiabetes = (FraminghamTable::where('code', 'DIABETES')
                ->where('gender', $user->gender->code)
                ->where('value_min', '<=', $clinicalHistory->is_diabetes ? 1 : 0)
                ->where('value_max', '>=', $clinicalHistory->is_diabetes ? 1 : 0)
                ->first())->score;

            $scoreSmoke = (FraminghamTable::where('code', 'SMOKE')
                ->where('gender', $user->gender->code)
                ->where('value_min', '<=', $clinicalHistory->is_smoke ? 1 : 0)
                ->where('value_max', '>=', $clinicalHistory->is_smoke ? 1 : 0)
                ->first())->score;

            $totalScore = $scoreAge + $scoreTotalCholesterol + $scoreHdlCholesterol + $scoreSystolic + $scoreDiabetes + $scoreSmoke;

            $risk = Risk::where('gender', $user->gender->code)
                ->where('age_min', '<=', $user->age)
                ->where('age_max', '>=', $user->age)
                ->where('value_min', '<=', $totalScore)
                ->where('value_max', '>=', $totalScore)
                ->first();

            if (isset($risk)) {
                $data = array(
                    'level' => $risk->level,
                    'interpretation' => $risk->interpretation);
            } else {
                $data = array(
                    'level' => 0,
                    'interpretation' => 'Sin Riesgo');
            }

//            return array(
//                'scoreAge' => $scoreAge,
//                'scoreTotalCholesterol' => $scoreTotalCholesterol,
//                'scoreHdlCholesterol' => $scoreHdlCholesterol,
//                'scoreBloodPressure' => $scoreSystolic,
//                'scoreDiabetes' => $scoreDiabetes,
//                'scoreSmoke' => $scoreSmoke,
//                'totalScore' => $totalScore,
//                'risk' => $risk
//            );
        }

        return json_decode(json_encode($data));
    }

    private function calculateIceScore($clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');
        $interpretation = '';
        $level = null;
        if (isset($clinicalHistory->ice)) {
            if ($clinicalHistory->ice < 0.5) {
                $interpretation = 'Bajo';
                $level = 1;
            }
            if ($clinicalHistory->ice >= 0.5 && $clinicalHistory->ice <= 0.54) {
                $interpretation = 'Moderado';
                $level = 2;
            }
            if ($clinicalHistory->ice >= 0.55) {
                $interpretation = 'Alto';
                $level = 4;
            }
            $data = array(
                'level' => $level,
                'interpretation' => $interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateNeckCircumferenceScore($user, $clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        $interpretation = '';
        $level = null;

        if (isset($user->gender, $clinicalHistory->neck_circumference)) {
            if ($user->gender->code === 'MALE') {
                if ($clinicalHistory->neck_circumference < 35) {
                    $interpretation = 'Moderado';
                    $level = 2;
                }
                if ($clinicalHistory->neck_circumference >= 35) {
                    $interpretation = 'Severo RCV';
                    $level = 4;
                }
            }

            if ($user->gender->code === 'FEMALE') {
                if ($clinicalHistory->neck_circumference < 32) {
                    $interpretation = 'Moderado';
                    $level = 2;
                }
                if ($clinicalHistory->neck_circumference >= 32) {
                    $interpretation = 'Severo RCV';
                    $level = 4;
                }
            }
            $data = array(
                'level' => $level,
                'interpretation' => $interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateSystolic($user, $clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        $interpretation = '';
        $level = null;

        if (isset($user->age, $clinicalHistory->systolic)) {

            if ($clinicalHistory->systolic < 110) {
                $interpretation = 'Bajo';
                $level = 1;
            }
            if ($clinicalHistory->systolic >= 110 && $clinicalHistory->systolic <= 140) {
                $interpretation = 'Normal';
                $level = 2;
            }
            if ($clinicalHistory->systolic > 140) {
                $interpretation = 'Alto';
                $level = 4;
            }

            $data = array(
                'level' => $level,
                'interpretation' => $interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateDiastolic($user, $clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        $interpretation = '';
        $level = null;

        if (isset($user->age, $clinicalHistory->diastolic)) {

            if ($clinicalHistory->diastolic < 70) {
                $interpretation = 'Bajo';
                $level = 1;
            }
            if ($clinicalHistory->diastolic >= 70 && $clinicalHistory->diastolic <= 90) {
                $interpretation = 'Normal';
                $level = 2;
            }
            if ($clinicalHistory->diastolic > 90) {
                $interpretation = 'Alto';
                $level = 4;
            }

            $data = array(
                'level' => $level,
                'interpretation' => $interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateHeartRate($user, $clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        $interpretation = '';
        $level = null;

        if (isset($user->age, $clinicalHistory->heart_rate)) {

            if ($clinicalHistory->heart_rate < 60) {
                $interpretation = 'Bajo';
                $level = 1;
            }
            if ($clinicalHistory->heart_rate >= 60 && $clinicalHistory->heart_rate <= 80) {
                $interpretation = 'Normal';
                $level = 2;
            }
            if ($clinicalHistory->heart_rate > 80) {
                $interpretation = 'Alto';
                $level = 4;
            }

            $data = array(
                'level' => $level,
                'interpretation' => $interpretation);
        }
        return json_decode(json_encode($data));
    }

    private function calculateBreathingFrequency($user, $clinicalHistory)
    {
        $data = array(
            'level' => 0,
            'interpretation' => 'Falta Información');

        $interpretation = '';
        $level = null;

        if (isset($user->age, $clinicalHistory->breathing_frequency)) {

            if ($clinicalHistory->breathingFrequency < 12) {
                $interpretation = 'Bajo';
                $level = 1;
            }
            if ($clinicalHistory->breathing_frequency >= 12 && $clinicalHistory->breathing_frequency <= 20) {
                $interpretation = 'Normal';
                $level = 2;
            }
            if ($clinicalHistory->breathing_frequency > 20) {
                $interpretation = 'Alto';
                $level = 4;
            }

            $data = array(
                'level' => $level,
                'interpretation' => $interpretation);
        }
        return json_decode(json_encode($data));
    }
}

