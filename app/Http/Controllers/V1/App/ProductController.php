<?php

namespace App\Http\Controllers\V1\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\App\Products\ProductCollection;
use App\Models\App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function catalogue(Request $request)
    {
        $products = Product::typeId($request->input('typeId'))->get();
        return (new ProductCollection($products))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }
}
