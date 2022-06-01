<?php

namespace App\Http\Controllers\V1\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\App\Tips\TipCollection;
//use Illuminate\Http\Request;
use App\Models\App\Tip;

class TipController extends Controller
{
    public function catalogue()
    {
        $tips = Tip::get();
        return (new TipCollection($tips))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
}
