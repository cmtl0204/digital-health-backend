<?php

namespace App\Http\Resources\V1\Cecy\DetailPlanificationInformNeeds;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DetailPlanificationInformNeedCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}
