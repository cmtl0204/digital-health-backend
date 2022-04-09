<?php

namespace App\Http\Resources\V1\App\UserPatients;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserPatientCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return [
            'data' => $this->collection
        ];
    }
}
