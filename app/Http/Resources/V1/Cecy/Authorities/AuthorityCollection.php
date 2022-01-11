<?php

namespace App\Http\Resources\V1\Cecy\Institutions;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InstitutionCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}