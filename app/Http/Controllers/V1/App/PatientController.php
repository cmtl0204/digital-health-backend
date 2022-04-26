<?php

namespace App\Http\Controllers\V1\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\Catalogues\IndexCatalogueRequest;
use App\Http\Requests\V1\App\Patients\RegisterPatientUserRequest;
use App\Http\Requests\V1\App\Patients\UpdatePatientUserRequest;
use App\Http\Resources\V1\App\ClinicalHistories\ClinicalHistoryCollection;
use App\Http\Resources\V1\App\ClinicalHistories\ClinicalHistoryResource;
use App\Http\Resources\V1\App\Patients\PatientResource;
use App\Http\Resources\V1\App\UserPatients\UserPatientResource;
use App\Http\Resources\V1\Core\Users\UserResource;
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
        $user->sex()->associate(Catalogue::find($request->input('sex.id')));
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
                    'summary' => 'Usuario creado',
                    'detail' => 'Se creó correctamente',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function updatePatientUser(UpdatePatientUserRequest $request, Patient $patient)
    {
        $user = $patient->user()->first();
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

        return (new UserPatientResource($user))
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

    public function showLastClinicalHistory(Patient $patient)
    {
        $user = $patient->user()->with('sex')->first();

        $clinicalHistory = $patient->clinicalHistories()
            ->orderByDesc('registered_at')
            ->first();

        $percentageBodyFat = $this->calculatePercentageBodyFat($user, $clinicalHistory);
        $percentageBodyWater = $this->calculatePercentageBodyWater($user, $clinicalHistory);
        $percentageVisceralFat = $this->calculatePercentageVisceralFat($user, $clinicalHistory);
        $muscleMass = $this->calculateMuscleMass($user, $clinicalHistory);
        $boneMass = $this->calculateBoneMass($user, $clinicalHistory);
        $iceScore = $this->calculateIceScore($clinicalHistory);
        $neckCircumference = $this->calculateNeckCircumferenceScore($user, $clinicalHistory);
        $scores = $this->calculateFraminghamTable($user, $clinicalHistory);

        $data = array(
            'bodyFat' => $percentageBodyFat,
            'percentageBodyWater' => $percentageBodyWater,
            'percentageVisceralFat' => $percentageVisceralFat,
            'muscleMass' => $muscleMass,
            'boneMass' => $boneMass,
            'ice' => $iceScore,
            'neckCircumference' => $neckCircumference,
            'risk' => $scores,
//            'scores' => $scores,
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

    private function calculatePercentageBodyFat($user, $clinicalHistory)
    {
        $result = 'Falta Información';

        if (isset($clinicalHistory->percentage_body_fat,$user->sex)) {
            $referenceValue = ReferenceValue::where('code', 'PBF')
                ->where('sex', $user->sex->code)
                ->where('age_min', '<=', $user->age)
                ->where('age_max', '>=', $user->age)
                ->where('value_min', '<=', $clinicalHistory->percentage_body_fat)
                ->where('value_max', '>=', $clinicalHistory->percentage_body_fat)
                ->first();
            if ($referenceValue)
                $result = $referenceValue->interpretation;
            else
                $result = 'Fuera del Rango';
        }
        return $result;
    }

    private function calculatePercentageBodyWater($user, $clinicalHistory)
    {
        $result = 'Falta Información';

        if (isset($clinicalHistory->percentage_body_water,$user->sex)) {
            $referenceValue = ReferenceValue::where('code', 'PBW')
                ->where('sex', $user->sex->code)
                ->where('value_min', '<=', $clinicalHistory->percentage_body_water)
                ->where('value_max', '>=', $clinicalHistory->percentage_body_water)
                ->first();
            if ($referenceValue)
                $result = $referenceValue->interpretation;
            else
                $result = 'Fuera del Rango';
        }
        return $result;
    }

    private function calculatePercentageVisceralFat($user, $clinicalHistory)
    {
        $result = 'Falta Información';

        if (isset($clinicalHistory->percentage_visceral_fat,$user->sex)) {
            $referenceValue = ReferenceValue::where('code', 'PVF')
                ->where('sex', $user->sex->code)
                ->where('value_min', '<=', $clinicalHistory->percentage_visceral_fat)
                ->where('value_max', '>=', $clinicalHistory->percentage_visceral_fat)
                ->first();
            if ($referenceValue)
                $result = $referenceValue->interpretation;
            else
                $result = 'Fuera del Rango';
        }
        return $result;
    }

    private function calculateMuscleMass($user, $clinicalHistory)
    {
        $result = 'Falta Información';

        if (isset($clinicalHistory->muscle_mass,$user->sex)) {
            $referenceValue = ReferenceValue::where('code', 'MM')
                ->where('sex', $user->sex->code)
                ->where('age_min', '<=', $user->age)
                ->where('age_max', '>=', $user->age)
                ->where('value_min', '<=', $clinicalHistory->muscle_mass)
                ->where('value_max', '>=', $clinicalHistory->muscle_mass)
                ->first();
            if ($referenceValue)
                $result = $referenceValue->interpretation;
            else
                $result = 'Fuera del Rango';
        }
        return $result;
    }

    private function calculateBoneMass($user, $clinicalHistory)
    {
        $result = 'Falta Información';

        if (isset($clinicalHistory->bone_mass,$user->sex)) {
            $referenceValue = ReferenceValue::where('code', 'BM')
                ->where('sex', $user->sex->code)
                ->where('weight_min', '<=', $clinicalHistory->weight)
                ->where('weight_max', '>=', $clinicalHistory->weight)
                ->where('value_min', '<=', $clinicalHistory->bone_mass)
                ->where('value_max', '>=', $clinicalHistory->bone_mass)
                ->first();
            if ($referenceValue)
                $result = $referenceValue->interpretation;
            else
                $result = 'Fuera del Rango';
        }
        return $result;
    }

    private function calculateFraminghamTable($user, $clinicalHistory)
    {
        $result = 'Falta Información';
        $totalScore = 0;
        if (isset($user->age,
            $user->sex,
            $clinicalHistory->total_cholesterol,
            $clinicalHistory->hdl_cholesterol,
            $clinicalHistory->blood_pressure,
            $clinicalHistory->is_diabetes,
            $clinicalHistory->is_smoke)) {
            $scoreAge = (FraminghamTable::where('code', 'AGE')
                ->where('sex', $user->sex->code)
                ->where('value_min', '<=', $user->age)
                ->where('value_max', '>=', $user->age)
                ->first())->score;

            $scoreTotalCholesterol = (FraminghamTable::where('code', 'CHOLESTEROL')
                ->where('sex', $user->sex->code)
                ->where('value_min', '<=', $clinicalHistory->total_cholesterol)
                ->where('value_max', '>=', $clinicalHistory->total_cholesterol)
                ->first())->score;

            $scoreHdlCholesterol = (FraminghamTable::where('code', 'HDL')
                ->where('sex', $user->sex->code)
                ->where('value_min', '<=', $clinicalHistory->hdl_cholesterol)
                ->where('value_max', '>=', $clinicalHistory->hdl_cholesterol)
                ->first())->score;

            $scoreBloodPressure = (FraminghamTable::where('code', 'BLOOD_PRESSURE')
                ->where('sex', $user->sex->code)
                ->where('value_min', '<=', $clinicalHistory->blood_pressure)
                ->where('value_max', '>=', $clinicalHistory->blood_pressure)
                ->first())->score;

            $scoreDiabetes = (FraminghamTable::where('code', 'DIABETES')
                ->where('sex', $user->sex->code)
                ->where('value_min', '<=', $clinicalHistory->is_diabetes ? 1 : 0)
                ->where('value_max', '>=', $clinicalHistory->is_diabetes ? 1 : 0)
                ->first())->score;

            $scoreSmoke = (FraminghamTable::where('code', 'SMOKE')
                ->where('sex', $user->sex->code)
                ->where('value_min', '<=', $clinicalHistory->is_smoke ? 1 : 0)
                ->where('value_max', '>=', $clinicalHistory->is_smoke ? 1 : 0)
                ->first())->score;

            $totalScore = $scoreAge + $scoreTotalCholesterol + $scoreHdlCholesterol + $scoreBloodPressure + $scoreDiabetes + $scoreSmoke;

            $risk = Risk::where('sex', $user->sex->code)
                ->where('age_min', '<=', $user->age)
                ->where('age_max', '>=', $user->age)
                ->where('value_min', '<=', $totalScore)
                ->where('value_max', '>=', $totalScore)
                ->first();

            return isset($risk) ? $risk->interpretation : 'Sin Riesgo';
            return array(
                'scoreAge' => $scoreAge,
                'scoreTotalCholesterol' => $scoreTotalCholesterol,
                'scoreHdlCholesterol' => $scoreHdlCholesterol,
                'scoreBloodPressure' => $scoreBloodPressure,
                'scoreDiabetes' => $scoreDiabetes,
                'scoreSmoke' => $scoreSmoke,
                'totalScore' => $totalScore,
                'risk' => $risk
            );
        }

        return $result;
    }

    private function calculateIceScore($clinicalHistory)
    {
        $result = 'Falta Información';
        if (isset($clinicalHistory->ice)) {
            if ($clinicalHistory->ice < 0.5) {
                $result = 'Bajo';
            }
            if ($clinicalHistory->ice >= 0.5 && $clinicalHistory->ice <= 0.54) {
                $result = 'Moderado';
            }
            if ($clinicalHistory->ice >= 0.55) {
                $result = 'Alto';
            }
        }
        return $result;
    }

    private function calculateNeckCircumferenceScore($user, $clinicalHistory)
    {
        $result = 'Falta Información';
        if (isset($user->sex, $clinicalHistory->neck_circumference)) {
            if ($user->sex->code === 'MALE') {
                if ($clinicalHistory->neck_circumference < 35) {
                    $result = 'Moderado';
                }
                if ($clinicalHistory->neck_circumference >= 35) {
                    $result = 'Severo RCV';
                }
            }

            if ($user->sex->code === 'FEMALE') {
                if ($clinicalHistory->neck_circumference < 32) {
                    $result = 'Moderado';
                }
                if ($clinicalHistory->neck_circumference >= 32) {
                    $result = 'Severo RCV';
                }
            }
        }
        return $result;
    }
}
