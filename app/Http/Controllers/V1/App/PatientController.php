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

    public function registerPatientUser(Request $request)
    {
        $user = User::where('username', $request->input('username'))
            ->orWhere('email', $request->input('email'))->first();

        if (isset($user) && $user->username === $request->input('username')) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El correo electrónico ya está en uso',
                    'detail' => 'Intente con otro nombre de usuario',
                    'code' => '200'
                ]
            ], 400);
        }

        if (isset($user) && $user->email === $request->input('email')) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'El usuario ya se encuentra registrado',
                    'detail' => 'Intente con otro correo electrónico',
                    'code' => '200'
                ]
            ], 400);
        }

        $user = new User();
        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->name = $request->input('name');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        $patient = new Patient();

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

    public function updatePatientUser(Request $request, Patient $patient)
    {
//        $user = User::where('username', $request->input('username'))
//            ->orWhere('email', $request->input('email'))->first();
//
//        if (isset($user) && $user->username === $request->input('username')) {
//            return (new UserResource($user))
//                ->additional([
//                    'msg' => [
//                        'summary' => 'El usuario ya se encuentra registrado',
//                        'detail' => 'Intente con otro nombre de usuario',
//                        'code' => '200'
//                    ]
//                ])
//                ->response()->setStatusCode(400);
//        }
//
//        if (isset($user) && $user->email === $request->input('email')) {
//            return (new UserResource($user))
//                ->additional([
//                    'msg' => [
//                        'summary' => 'El correo electrónico ya está en uso',
//                        'detail' => 'Intente con otro correo electrónico',
//                        'code' => '200'
//                    ]
//                ])->response()->setStatusCode(400);
//        }
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

    public function storeClinicalHistory(Request $request, Patient $patient)
    {
        $patient->is_smoke = $request->input('is_smoke');
        $patient->save();

        $clinicalHistory = new ClinicalHistory();
        $clinicalHistory->patient()->associate($patient);
        $clinicalHistory->basal_metabolic_rate = $request->input('basalMetabolicRate');
        $clinicalHistory->blood_pressure = $request->input('bloodPressure');
        $clinicalHistory->breathing_frequency = $request->input('breathingFrequency');
        $clinicalHistory->glucose = $request->input('glucose');
        $clinicalHistory->hdl_cholesterol = $request->input('hdlCholesterol');
        $clinicalHistory->heart_rate = $request->input('heartRate');
        $clinicalHistory->height = $request->input('height');
        $clinicalHistory->imc = $request->input('weight') / $request->input('height') * $request->input('height');
        $clinicalHistory->ldl_cholesterol = $request->input('ldlCholesterol');
        $clinicalHistory->metabolic_age = $request->input('metabolicAge');
        $clinicalHistory->neck_circumference = $request->input('neckCircumference');
        $clinicalHistory->percentage_body_fat = $request->input('percentageBodyFat');
        $clinicalHistory->percentage_body_mass = $request->input('percentageBodyMass');
        $clinicalHistory->percentage_body_water = $request->input('percentageBodyWater');
        $clinicalHistory->percentage_bone_mass = $request->input('percentageBoneMass');
        $clinicalHistory->percentage_visceral_fat = $request->input('percentageVisceralFat');
        $clinicalHistory->registered_at = $request->input('registeredAt');
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

    public function updateClinicalHistory(Request $request, Patient $patient, ClinicalHistory $clinicalHistory)
    {
        $patient->is_smoke = $request->input('is_smoke');
        $patient->save();

        $clinicalHistory->patient()->associate($patient);
        $clinicalHistory->basal_metabolic_rate = $request->input('basalMetabolicRate');
        $clinicalHistory->blood_pressure = $request->input('bloodPressure');
        $clinicalHistory->breathing_frequency = $request->input('breathingFrequency');
        $clinicalHistory->glucose = $request->input('glucose');
        $clinicalHistory->hdl_cholesterol = $request->input('hdlCholesterol');
        $clinicalHistory->heart_rate = $request->input('heartRate');
        $clinicalHistory->height = $request->input('height');
        $clinicalHistory->imc = $request->input('weight') / $request->input('height') * $request->input('height');
        $clinicalHistory->ldl_cholesterol = $request->input('ldlCholesterol');
        $clinicalHistory->metabolic_age = $request->input('metabolicAge');
        $clinicalHistory->neck_circumference = $request->input('neckCircumference');
        $clinicalHistory->percentage_body_fat = $request->input('percentageBodyFat');
        $clinicalHistory->percentage_body_mass = $request->input('percentageBodyMass');
        $clinicalHistory->percentage_body_water = $request->input('percentageBodyWater');
        $clinicalHistory->percentage_bone_mass = $request->input('percentageBoneMass');
        $clinicalHistory->percentage_visceral_fat = $request->input('percentageVisceralFat');
        $clinicalHistory->registered_at = $request->input('registeredAt');
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

    public function getClinicalHistories(Request $request, Patient $patient)
    {
        $clinicalHistories = $patient->clinicalHistories()
            ->orderBy('registered_at')
            ->get();

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
}
