<?php

namespace Modules\AdminPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\AdminPanel\Http\Requests\CreateCompanyRequest;
use Modules\AdminPanel\Http\Requests\UpdateCompanyRequest;
use Modules\Company\Models\Company;
use Modules\Company\Models\Company_meta;

use function PHPUnit\Framework\isEmpty;

class CompanyController extends Controller
{
    public function create(CreateCompanyRequest $request)
    {
        $logoPath = null;
        if (isset($request->logo)){
            $logoPath = $request->logo->store('logos', 'public');
        }
        $timestamp = (string) time();
        $company = Company::createCompany($request, $timestamp, $logoPath);
        Company_meta::createMetas($company);
    }
    public function delete($id)
    {
        $company = Company::findOrFail($id);
        $path = str_replace('/storage/', '', parse_url($company->logo, PHP_URL_PATH));
        Storage::disk('public')->delete($path);
        $company->delete();
    }
    public function update(UpdateCompanyRequest $request)
    {
        if(!empty($request->file('logo'))){
            $this->updateLogo($request->logo, $request->id);
        }
        Company::updateCompany($request);
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
}
