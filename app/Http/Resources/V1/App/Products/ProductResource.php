<?php

namespace App\Http\Resources\V1\App\Products;

use App\Http\Resources\V1\App\Catalogues\CatalogueResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'type' => CatalogueResource::make($this->type),
            'name' => $this->name,
            'energy' => $this->energy,
            'fiber' => $this->fiber,
            'protein' => $this->protein,
            'lipids' => $this->lipids,
            'carbohydrates' => $this->carbohydrates,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'netWeight' => $this->net_weight,
        ];
    }
}
