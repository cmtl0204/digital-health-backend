<?php

namespace App\Http\Resources\V1\App\Patients;

use App\Http\Resources\V1\App\Catalogues\CatalogueResource;
use App\Http\Resources\V1\App\ClinicalHistories\ClinicalHistoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'sector' => CatalogueResource::make($this->sector) ,
            'clinicalHistories' => ClinicalHistoryResource::collection($this->clinicalHistories) ,
            'is_smoke' => $this->is_smoke,
        ];
    }
}
