<?php

namespace App\Http\Controllers\V1\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\Catalogues\UpdatePatientUserRequest;
use App\Http\Requests\V1\App\Catalogues\IndexCatalogueRequest;
use App\Http\Resources\V1\App\Catalogues\CatalogueCollection;
use App\Models\App\Catalogue;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:store-catalogues')->only(['store']);
        $this->middleware('permission:update-catalogues')->only(['update']);
        $this->middleware('permission:delete-catalogues')->only(['destroy', 'destroys']);
    }

    public function index(IndexCatalogueRequest $request)
    {
        $sorts = explode(',', $request->sort);

        $catalogues = Catalogue::customOrderBy($sorts)
            ->type($request->input('type'))
            ->paginate($request->input('perPage'));

        return (new PatientCollection($catalogues))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ]);
    }

    public function catalogue(Request $request)
    {
        $sorts = explode(',', $request->sort);
        $catalogues = Catalogue::customOrderBy($sorts)
            ->description($request->input('search'))
            ->name($request->input('search'))
            ->type($request->input('search'))
            ->limit(1000)
            ->get();

        return (new CatalogueCollection($catalogues))
            ->additional([
                'msg' => [
                    'summary' => 'success',
                    'detail' => '',
                    'code' => '200'
                ]
            ])
            ->response()->setStatusCode(200);
    }
}
