<?php

namespace Modules\Flight\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Auth\Models\User;
use Modules\Flight\Http\Requests\CreateFlightByExcelRequest;
use Modules\Flight\Http\Requests\CreateFlightRequest;
use Modules\Flight\Http\Requests\UpdateFlightRequest;
use Modules\Flight\Imports\FlightImport;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\Flight_meta;
use Modules\Flight\Models\Flight_option;
use Modules\Flight\Services\ValidateAndCreateFlightService;
use Tymon\JWTAuth\Facades\JWTAuth;

class FlightController extends Controller
{
    public function create(CreateFlightRequest $request)
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $companyId = User::getCompanyIdById($userId);
        DB::transaction(function() use ($request, $companyId) {
            $flight = Flight::createFlight($request, $companyId);
            Flight_meta::createMetas($flight);
            foreach ($request->options as $option){
                Flight_option::createOption((object) $option, $flight->id);
            }
        });
    }
    public function findOne($slug)
    {
        return Flight::findOneBySlug($slug);
    }
    public function delete($id)
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $companyId = User::getCompanyIdById($userId);
        return Flight::deleteFlight($id, $companyId);
    }
    public function update(UpdateFlightRequest $request)
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $companyId = User::getCompanyIdById($userId);
        Flight::updateFlight($request, $companyId);
    }
    public function createExcel(CreateFlightByExcelRequest $request, ValidateAndCreateFlightService $service)
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $companyId = User::getCompanyIdById($userId);
        Excel::import(new FlightImport($companyId, $service), $request->file('file'));
    }
}
