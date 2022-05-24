<?php

namespace App\Http\Resources\V1\Core\Users;

use App\Http\Resources\V1\Authentication\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\Core\Catalogues\CatalogueResource;
use App\Http\Resources\V1\Core\EmailResource;
use App\Http\Resources\V1\Core\PhoneResource;

class UserResource extends JsonResource
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
            'avatar' => $this->avatar,
            'age' => $this->age,
            'username' => $this->username,
            'name' => $this->name,
            'gender' => CatalogueResource::make($this->gender),
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'birthdate' => $this->birthdate,
            'roles' => RoleResource::collection($this->roles),
            'sex' => CatalogueResource::make($this->sex),
            'bloodType' => CatalogueResource::make($this->bloodType),
            'passwordChanged' => $this->password_changed,
            'suspended' => $this->suspended,
            'updatedAt' => $this->updated_at,
        ];
    }

//    public function with($request)
//    {
//        return [
//            'message' => [
//                'summary' => '',
//                'detail' => ''
//            ]
//        ];
//    }
}
