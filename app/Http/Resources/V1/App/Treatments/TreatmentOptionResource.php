<?php

namespace App\Http\Resources\V1\App\Treatments;

use App\Http\Resources\V1\App\Catalogues\CatalogueResource;
use App\Http\Resources\V1\App\Products\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentOptionResource extends JsonResource
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
            'product' => ProductResource::make($this->product),
            'quantity' => $this->quantity,
            'unit' => $this->unit,
        ];
    }
}
