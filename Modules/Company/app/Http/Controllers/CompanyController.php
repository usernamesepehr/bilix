<?php

namespace Modules\Company\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Models\User;
use Modules\Company\Http\Requests\UpdateCompanyRequest;
use Modules\Company\Models\Company;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompanyController extends Controller
{
    public function update(UpdateCompanyRequest $request)
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $companyId = User::getCompanyIdById($userId);
        Company::updateCompany($request,$companyId);
    }
    private function updateLogo($logo, $id)
    {
        $company = Company::findOrFail($id);
        $oldPath = str_replace('/storage/', '', parse_url($company->logo, PHP_URL_PATH));
        Storage::disk('public')->delete($oldPath);
        $path = $logo->store('logos', 'public');
        $company->logo = asset('/storage/' . $path);
        $company->save();
    }
    public function get(): JsonResponse
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $companyId = User::getCompanyIdById($userId);
        $company = Company::findOrFail($companyId);
        return response()->json($company);
    }
    public function search(): JsonResponse        
    {
        $perPage = request()->input('per_page');
        $companies =  Company::viaIndex()->searchTerm(request()->input('q'))->paginate($perPage);
        return response()->json($companies);
    }
}
