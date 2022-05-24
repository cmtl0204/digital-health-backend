<?php

namespace App\Http\Controllers\V1\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\Catalogues\IndexCatalogueRequest;
use App\Http\Resources\V1\App\ClinicalHistories\TreatmentCollection;
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

        return (new TreatmentCollection($clinicalHistories))
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

    public function getByPatient(Patient $patient)
    {
        $clinicalHistories = $patient->clinicalHistories()
            ->orderBy('registered_at')
            ->get();

        return (new TreatmentCollection($clinicalHistories))
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
