<?php

namespace App\Http\Resources\V1\App\Tips;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TipCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }

//    public function with($request)
//    {
//        if ($this->total() !== null) {
//            return [
//                'meta' => [
//                    'totalItems' => $this->total(),
//                    'currentPage' => $this->currentPage(),
//                    'perPage' => $this->perPage(),
//                    'lastPage' => $this->lastPage(),
//                    'firstItem' => $this->firstItem(),
//                    'lastItem' => $this->lastItem()
//                ],
//            ];
//        }
//    }
}
