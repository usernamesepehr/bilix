<?php

namespace Modules\UserPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Models\User;
use Modules\UserPanel\Http\Requests\UpdateMeRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateMeController extends Controller
{
   public function __invoke(UpdateMeRequest $request)
   {
      $userId = JWTAuth::parseToken()->getPayload()->get('id');
      if ($request->profile) {
            $this->updateProfile($request->profile, $userId);
      }
      User::updateUser($request, $userId);
   }
   private function updateProfile($profile, $userId)
   {
    $user = User::findOrFail($userId);
        $path = str_replace('/storage/', '', parse_url($user->profile, PHP_URL_PATH));
        Storage::disk('public')->delete($path);
        $profilePath = $profile->store('profiles', 'public');
        $user->profile = asset('storage/' . $profilePath);
        $user->save();
   }
}
