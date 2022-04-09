<?php

namespace App\Http\Resources\V1\App\UserPatients;

use App\Http\Resources\V1\App\Patients\PatientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPatientResource extends JsonResource
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
            'username' => $this->username,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
