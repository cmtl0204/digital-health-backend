<?php

namespace App\Http\Controllers\V1\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\App\Products\ProductCollection;
use App\Http\Resources\V1\App\Treatments\TreatmentCollection;
use App\Http\Resources\V1\App\Treatments\TreatmentDetailCollection;
use App\Http\Resources\V1\App\Treatments\TreatmentDetailResource;
use App\Http\Resources\V1\App\Treatments\TreatmentOptionResource;
use App\Http\Resources\V1\App\Treatments\TreatmentResource;
use App\Models\App\Catalogue;
use App\Models\App\Patient;
use App\Models\App\Product;
use App\Models\App\Treatment;
use App\Models\App\TreatmentDetail;
use App\Models\App\TreatmentOption;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(Request $request, Patient $patient)
    {
        $treatment = new Treatment();
        $treatment->patient()->associate($patient);
        $treatment->ended_at = $request->input('endedAt');
        $treatment->started_at = $request->input('startedAt');
        $treatment->time_started_at = $request->input('timeStartedAt');
        $treatment->published = $request->input('published');
        $treatment->save();

        return (new TreatmentResource($treatment))
            ->additional([
                'msg' => [
                    'summary' => 'Fechas creadas',
                    'detail' => 'Las fechas y hora de inicio fueron creadas correctamente',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function storeTreatmentDetail(Request $request, Treatment $treatment)
    {
        $type = Catalogue::find($request->input('type.id'));
        $treatmentDetail = new TreatmentDetail();
        $treatmentDetail->treatment()->associate($treatment);
        $treatmentDetail->product()->associate(Product::find($request->input('product.id')));
        $treatmentDetail->type()->associate($type);
        $treatmentDetail->unit = $request->input('unit');
        $treatmentDetail->quantity = $request->input('quantity');
        $treatmentDetail->time_started_at = $this->calculateTimeStartedAt($treatment, $type);

        $treatmentDetail->save();

        foreach ($request->input('treatmentOptions') as $treatmentOption) {
            $this->storeTreatmentOption($treatmentOption, $treatmentDetail);
        }
        return (new TreatmentDetailResource($treatmentDetail))
            ->additional([
                'msg' => [
                    'summary' => 'Producto agregado',
                    'detail' => 'El producto se agregó correctamente',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    private function storeTreatmentOption($request, TreatmentDetail $treatmentDetail)
    {
        $treatmentOption = new TreatmentOption();
        $treatmentOption->treatmentDetail()->associate($treatmentDetail);
        $treatmentOption->product()->associate(Product::find($request['product']['id']));
        $treatmentOption->unit = $request['unit'];
        $treatmentOption->quantity = $request['quantity'];

        $treatmentOption->save();

        return (new TreatmentOptionResource($treatmentOption))
            ->additional([
                'msg' => [
                    'summary' => 'Opción agregada',
                    'detail' => 'Se creó la opción',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    private function calculateTimeStartedAt($treatment, $type)
    {
        switch ($type->code) {
            case '1':
                return $treatment->time_started_at;
            case '2':
                return $treatment->time_started_at;
            case '3':
                return (Carbon::create($treatment->time_started_at))->addHours(3);
            case '4':
                return (Carbon::create($treatment->time_started_at))->addHours(5);
            case '5':
                return (Carbon::create($treatment->time_started_at))->addHours(8);
            case '6':
                return (Carbon::create($treatment->time_started_at))->addHours(10);
            default :
                return null;
        }
    }

    private function updateTreatmentDetailTimeStartedAt($treatment)
    {
        $treatmentDetails = $treatment->treatmentDetails()->with('type')->get();

        foreach ($treatmentDetails as $treatmentDetail) {
            switch ($treatmentDetail->type->code) {
                case '1':
                    $treatmentDetail->time_started_at = $treatment->time_started_at;
                    break;
                case '2':
                    $treatmentDetail->time_started_at = $treatment->time_started_at;
                    break;
                case '3':
                    $treatmentDetail->time_started_at = (Carbon::create($treatment->time_started_at))->addHours(3);
                    break;
                case '4':
                    $treatmentDetail->time_started_at = (Carbon::create($treatment->time_started_at))->addHours(5);
                    break;
                case '5':
                    $treatmentDetail->time_started_at = (Carbon::create($treatment->time_started_at))->addHours(8);
                    break;
                case '6':
                    $treatmentDetail->time_started_at = (Carbon::create($treatment->time_started_at))->addHours(10);
                    break;
            }
            $treatmentDetail->save();
        }

    }

    public function show(Treatment $treatment)
    {

    }

    public function update(Request $request, Treatment $treatment)
    {
        $treatment->ended_at = $request->input('endedAt');
        $treatment->started_at = $request->input('startedAt');
        $treatment->time_started_at = $request->input('timeStartedAt');
        $treatment->published = $request->input('published');
        $treatment->save();

        $this->updateTreatmentDetailTimeStartedAt($treatment);

        return (new TreatmentResource($treatment))
            ->additional([
                'msg' => [
                    'summary' => 'Fechas actualizadas',
                    'detail' => 'Las fechas y hora de inicio fueron actualizadas correctamente',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function updateTreatmentDetail(Request $request, TreatmentDetail $treatmentDetail)
    {
        $treatmentDetail->product()->associate(Product::find($request->input('product.id')));
        $treatmentDetail->unit = $request->input('unit');
        $treatmentDetail->quantity = $request->input('quantity');
        $treatmentDetail->time_started_at = $request->input('timeStartedAt');

        $treatmentDetail->save();

        $treatmentOptions = $treatmentDetail->treatmentOptions()->get();
        TreatmentOption::destroy($treatmentOptions->modelKeys());

        foreach ($request->input('treatmentOptions') as $treatmentOption) {
            $this->storeTreatmentOption($treatmentOption, $treatmentDetail);
        }
        return (new TreatmentDetailResource($treatmentDetail))
            ->additional([
                'msg' => [
                    'summary' => 'Producto agregado',
                    'detail' => 'El producto se agregó correctamente',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function destroy(Treatment $treatment)
    {
        //
    }

    public function destroyTreatmentDetail(TreatmentDetail $treatmentDetail)
    {
        $treatmentDetail->forceDelete();
        return (new TreatmentDetailResource($treatmentDetail))
            ->additional([
                'msg' => [
                    'summary' => 'Producto eliminado',
                    'detail' => '',
                    'code' => '201'
                ]
            ])
            ->response()->setStatusCode(201);
    }

    public function getLastByPatient(Patient $patient)
    {
        $treatment = $patient->treatments()->orderByDesc('started_at')->first();
        if (!isset($treatment)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No tiene tratamiento',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
        }
        return (new TreatmentResource($treatment))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    public function getTreatmentDetails(Treatment $treatment)
    {
        $treatmentDetails = $treatment->treatmentDetails()->orderBy('type_id')->get();

        return (new TreatmentDetailCollection($treatmentDetails))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
}
