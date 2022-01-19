<?php

namespace App\Http\Controllers\V1\Cecy;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Cecy\SchoolPeriods\SchoolPeriodsCollection;
use App\Http\Resources\V1\Cecy\DetailsPlanifications\PlanificationCollection;
use App\Http\Resources\V1\Cecy\DetailsPlanifications\PlanificationResource;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Classroom;
use App\Models\Cecy\Course;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Planification;
use App\Models\Cecy\SchoolPeriod;
use App\Models\Core\Catalogue;
use App\Models\Core\Career;

class GuanunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-Planifications')->only(['view']);
        $this->middleware('permission:store-Planifications')->only(['store']);
        $this->middleware('permission:store-detailPlanifications')->only(['store']);
        $this->middleware('permission:update-detailPlanifications')->only(['update']);
        $this->middleware('permission:view-details_planifications')->only(['view']);
    }
    /**
     *  Planifications
     */

     //--Coordinador de carrera
//buscar peridos lectivos y carrera
public function getCoursesByPeriod(Planification $courses)
{
    return (new SchoolPeriodsCollection($courses))
    ->additional([
        'msg' => [
            'summary' => '',
            'detail' => '',
            'code' => '200'
        ]
    ]);
}
//mostrar  carreras
public function getCarrers(Career $careers)
    {
        return (new CareerCollection($careers))
    ->additional([
        'msg' => [
            'summary' => '',
            'detail' => '',
            'code' => '200'
        ]
    ]);
    }

//mostrar informacion de la planificacion al coordinadoor de carrera
public function showPlanificationByCoordinator(Planification $planifications)
{return (new PlanificationCollection($planifications))
    ->additional([
        'msg' => [
            'sumary' => 'consulta exitosa',
            'detail' => '',
            'code' => '200'
        ]
    ]);
}
//Crear un curso y asignar responsable
public function storePlanificationCourse()
{
    $planifications = new Planification();
    $planifications->course()->associate(Course::find($request->input('name.id')));
    $planifications->duration()->associate(Course::find($request->input('duration.id')));
    $planifications->responsibleCourse()->associate(Instructor::find($request->input('user.id')));
    $planifications->ended_at = $request->input('fin de la planificación');
    $planifications->started_at = $request->input('inicio de la planificación');
    $planifications->save();

    return (new planificationsResource($planifications))
    ->additional([
        'msg' => [
            'summary' => 'planificación creada',
            'detail' => '',
            'code' => '200'
        ]
    ]);
}
//mostrar informacion al responsable del cecy
public function showplanificationByResponsibleCecy(){


}
//consultar el detalle de planificacion
public function getdetailPlanification(DetailPlanifications $details_planifications)
{
    return (new DetailPlanifications($details_planifications))
    ->additional([
        'msg' => [
            'summary' => '',
            'detail' => '',
            'code' => '200'
        ]
    ]);
}
//mostrar los kfi
public function getCoursesKFI(Course $courses)
{
    return (new Course($courses))
    ->additional([
        'msg' => [
            'summary' => '',
            'detail' => '',
            'code' => '200'
        ]
    ]);
}
//editar informacion del detalle planificación
public function updatedetailPlanification()
{
    $classroom = Classroom::find($request->input('classroom.id'));
    $code = Course::find($request->input('code.id'));
    $days = Catalogue::find($request->input('day.id'));
    $planification = Planification::find($request->input('planification.id'));
    $workday = Catalogue::find($request->input('workday.id'));
    $state = Catalogue::find($request->input('state.id'));

    $detailPlanification = DetailPlanification::find($request->input('detailPlanification.id'));

    $detailPlanification->classroom()->associate($classroom);
    $detailPlanification->code()->associate($code);
    $detailPlanification->day()->associate($days);
    $detailPlanification->planification()->associate($planification);
    $detailPlanification->workday()->associate($workday);

    $detailPlanification->days_number = $request->input('days_number');
    $detailPlanification->ended_at = $request->input('ended_at');
    $detailPlanification->plan_ended_at = $request->input('plan_ended_at');
    $detailPlanification->started_at = $request->input('started_at');
    $detailPlanification->save();

    return (new DetailPlanificationResource($detailPlanification))
        ->additional([
            'msg' => [
                'summary' => 'Actualizado correctamente',
                'detail' => '',
                'code' => '200'
            ]
        ]);
}
//recibir notificaciones
// public function getnotification()
// {
//     return (new NotificationCollection($notifications))
//     ->additional([
//         'msg' => [
//             'summary' => '',
//             'detail' => '',
//             'code' => '200'
//         ]
//     ]);
// }
}