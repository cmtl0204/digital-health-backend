<?php

namespace App\Http\Resources\V1\App\Treatments;

use App\Http\Resources\V1\App\Catalogues\CatalogueResource;
use App\Http\Resources\V1\App\Products\ProductResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentDetailResource extends JsonResource
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
            'treatmentOptions' => TreatmentOptionResource::collection($this->treatmentOptions),
            'product' => ProductResource::make($this->product),
            'type' => CatalogueResource::make($this->type),
            'unit' => $this->unit,
            'quantity' => $this->quantity,
            'timeStartedAt' => (Carbon::create($this->time_started_at))->format('H:i'),
        ];
    }
}
