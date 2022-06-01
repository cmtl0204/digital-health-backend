<?php

namespace App\Http\Resources\V1\App\Tips;

use Illuminate\Http\Resources\Json\JsonResource;

class TipResource extends JsonResource
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
            'description' => $this->description,
            'source' => $this->source
        ];
    }
}
