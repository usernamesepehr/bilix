<?php

namespace Modules\Company\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Modules\Company\Http\Requests\CreatePersonnelRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class PersonnelController extends Controller
{
  public function create(CreatePersonnelRequest $request)
  {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $companyId = User::getCompanyIdById($userId);
        $profilePath = null;

        if(isset($request->profile)){
        $profilePath = $request->profile->store('profiles', 'public');
        }
  
        $timestamp = (string) time();

        User::createUser($request, $profilePath, $timestamp, 1, $companyId);
  }
  public function findAll()
  {
       $userId = JWTAuth::parseToken()->getPayload()->get('id');
       $companyId = User::getCompanyIdById($userId);
       return User::getPersonnels($companyId);
  }
  public function findOne($id)
  {
      $userId = JWTAuth::parseToken()->getPayload()->get('id');
      $companyId = User::getCompanyIdById($userId);
      $user = User::getPersonnel($id, $companyId);
      $user->role = $this->mapRole($user->role);
      return $user;
  }
  public function delete($id)
  {
     $userId = JWTAuth::parseToken()->getPayload()->get('id');
     $companyId = User::getCompanyIdById($userId);
     User::deletePersonnel($id, $companyId);
  }
  private function mapRole($roleId)
    {
        $roleMap = [
           0 => 'کاربر',
           1 => 'مدیر شرکت',
           3 => 'مالک شرکت',
           4 => 'ادمین',
           5 => 'مالک'
        ];
        return $roleMap[$roleId];
    }
}
