<?php

namespace Modules\AdminPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdminPanel\Http\Requests\CreateUserRequest;
use Modules\AdminPanel\Http\Requests\UpdateUserRequest;
use Modules\Auth\Models\User;

class UserController extends Controller
{
   public function create(CreateUserRequest $request)
   {
        $profilePath = null;

        if(isset($request->profile)){
        $profilePath = $request->profile->store('profiles', 'public');
        }
        $role = $this->mapRole($request->role);
        $timestamp = (string) time();

        User::createUser($request, $profilePath, $timestamp, $role, $request->company_id);
   }
   private function mapRole(string|null $role)
    {
        $roleMap = [
           'کاربر' => 0,
           'مدیر شرکت' => 1,
           'مالک شرکت' => 2,
           'ادمین' => 3,
           'پشتیبان' => 5
        ];
        return $roleMap[$role];
    }
   public function update(UpdateUserRequest $request)
   {

   }
   public function findOne($id)
   {

   }
   public function findAll()
   {

   }
   public function delete($id)
   {

   }
}
