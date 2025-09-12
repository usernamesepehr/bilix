<?php

namespace Modules\Company\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Models\User;
use Modules\Company\Http\Requests\CreateCertificateRequest;
use Modules\Company\Models\Certificate;
use Modules\Company\Models\Company;
use Tymon\JWTAuth\Facades\JWTAuth;

class CertificateController extends Controller
{
    public function create(CreateCertificateRequest $request)
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $companyId = User::getCompanyIdById($userId);
        $photoPath = $request->photo->store('certificates', 'public');
        Certificate::createCertificate($request, $photoPath, $companyId);
    }
    public function findAll()
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $companyId = User::getCompanyIdById($userId);
        $company = Company::findOrFail($companyId);
        return $company->certificates;
    }
    public function delete($certificateId)
   {
      $userId = JWTAuth::parseToken()->getPayload()->get('id');
      $companyId = User::getCompanyIdById($userId);
      Certificate::deleteCertificate($certificateId, $companyId);
   }
}
