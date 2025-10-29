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
use Modules\Flight\Http\Requests\UpdateMultipleRequest;
use Modules\Flight\Imports\FlightMultiSheetImport;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\Flight_meta;
use Modules\Flight\Models\Flight_option;
use Modules\Flight\Services\FilterService;
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
    public function deleteByAdmin($id)
    {
        Flight::where('id', $id)->delete();
    }
    public function update(UpdateFlightRequest $request)
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $companyId = User::getCompanyIdById($userId);
        Flight::updateFlight($request, $companyId);
    }
    public function createExcel(CreateFlightByExcelRequest $request)
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $companyId = User::getCompanyIdById($userId);
        Excel::import(new FlightMultiSheetImport ($companyId), $request->file('file'));
    }
    public function findByFilter(Request $request, FilterService $filterService)
    {
        $flights = $filterService->apply(Flight::query()->with('FlightOptions'))->paginate($request->input('per_page' ?? 10));
        return response()->json($flights);
    }
    public function updateMultiple(UpdateMultipleRequest $request)
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $userRole = JWTAuth::parseToken()->getPayload()->get('role');
        DB::beginTransaction();
        try{
         $query = Flight::whereIn('id', $request->ids);
        if (!in_array($userRole, [3, 4])) {
            $companyId = User::getCompanyIdById($userId);
            $query->where('company_id', $companyId);
        }
        $query->update($request->except('ids', 'company_id', 'slug'));
        DB::commit();
        }catch(\Exception $e) {
            dd($e->getMessage());
        DB::rollBack();
        return response()->json([], 422);   
        }
        } 
    }


