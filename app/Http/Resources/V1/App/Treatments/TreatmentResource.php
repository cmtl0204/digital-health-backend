<?php

namespace App\Http\Resources\V1\App\Treatments;

use App\Http\Resources\V1\App\Catalogues\CatalogueResource;
use App\Http\Resources\V1\App\Patients\PatientResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient' => PatientResource::make($this->patient),
            'endedAt' => (Carbon::create($this->ended_at))->format('Y-m-d'),
            'startedAt' => (Carbon::create($this->started_at))->format('Y-m-d'),
            'timeStartedAt' => (Carbon::create($this->time_started_at))->format('H:i'),
            'published' => $this->published,
        ];
    }
}
