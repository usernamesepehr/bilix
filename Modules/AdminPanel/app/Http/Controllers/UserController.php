<?php

namespace Modules\AdminPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $role = $this->mapStrRoleToRoleId($request->role);
        $timestamp = (string) time();

        User::createUser($request, $profilePath, $timestamp, $role, $request->company_id);
   }
   private function mapStrRoleToRoleId(string|null $role)
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
   private function mapRoleIdToStrRole($roleId)
   {
      $roleMap = [
           0 => 'کاربر',
           1 => 'مدیر شرکت',
           2 => 'مالک شرکت',
           3 => 'ادمین',
           4 => 'مالک',
           5 => 'پشتیبان'
        ];
      return $roleMap[$roleId];
   }
   public function update(UpdateUserRequest $request)
   {
      $data = $request->validated();
      if ($request->profile) $this->updateProfile($request->profile, $request->id);
      $data['role'] = $this->mapStrRoleToRoleId($data['role']);
      User::updateUserByAdmin($data, $request->id);
   }
   private function  updateProfile($profile, $userId)
   {
    $user = User::findOrFail($userId);
        $path = str_replace('/storage/', '', parse_url($user->profile, PHP_URL_PATH));
        Storage::disk('public')->delete($path);
        $profilePath = $profile->store('profiles', 'public');
        $user->profile = asset('storage/' . $profilePath);
        $user->save();
   }
   public function findOne($id)
   {
      $user = User::with('company')->findOrFail($id);
      $user->role = $this->mapRoleIdToStrRole($user->role);
      return response()->json(['user' => $user]);
   }

   public function findAll()
   {
      $perPage = request()->input('per_page') ?? 10;
      $users = User::with('company')->paginate($perPage);
      $users->transform(function ($user) {
         $user->role = $this->mapRoleIdToStrRole($user->role);
         return $user;
      });
      return response()->json(['users' => $users]);
   }
   public function delete($id)
   {
      User::where('id', $id)->delete();
   }
}
