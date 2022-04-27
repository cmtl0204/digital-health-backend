<?php

namespace App\Http\Resources\V1\App\Patients;

use App\Http\Resources\V1\App\Catalogues\CatalogueResource;
use App\Http\Resources\V1\App\ClinicalHistories\ClinicalHistoryResource;
use App\Http\Resources\V1\Core\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'sex' => CatalogueResource::make($this->user->sex) ,
            'name' => $this->user->name,
            'lastname' => $this->user->lastname,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'birthdate' => $this->user->birthdate,
        ];
    }
}
