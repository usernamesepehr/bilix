<?php

namespace Modules\Company\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Modules\Company\Models\Airport_company;
use Modules\Company\Models\Company;
use Tymon\JWTAuth\Facades\JWTAuth;

class AirportController extends Controller
{
   public function create($airportId)
   {
      $userId = JWTAuth::parseToken()->getPayload()->get('id');
      $companyId = User::getCompanyIdById($userId);
      Airport_company::createAirportCompany($companyId, $airportId);
   }
   public function findAll()
   {
      $userId = JWTAuth::parseToken()->getPayload()->get('id');
      $companyId = User::getCompanyIdById($userId);
      $company = Company::findOrFail($companyId);
      return $company->airports;
   }
   public function delete($airportId)
   {
      $userId = JWTAuth::parseToken()->getPayload()->get('id');
      $companyId = User::getCompanyIdById($userId);
      Airport_company::deleteAirportCompany($airportId, $companyId);
   }
}
