<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Emails\RegisterMail;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
   public function register(RegisterRequest $request)
   {
       $profilePath = null;

        if(isset($request->profile)){
        $profilePath = $this->storeProfile($request->profile);
        }

        $timestamp = (string) time();

        $user = User::createUser($request, $profilePath, $timestamp);

        $token = JWTAuth::claims([$user->id])->fromUser($user);

        Mail::to($user->email)->send(new RegisterMail($user->name));
        return response()->json(['token' => $token, 'type' => 'bearer']);
   }
   private function storeProfile($profile)
   {
        return $profile->store('profiles', 'public');
   }
   public function login(LoginRequest $request)
   {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
          return response()->json([], 401);
        }
        $token = JWTAuth::claims([Auth::id()])->fromUser(Auth::user());

        Log::channel('login')->info('یوزر لاگین کرد!', [
            'user_id' => auth::id(),
            'email' => Auth::user()->phone,
            'ip' => $request->ip(),
        ]);

        return response()->json(['token' => $token, 'type' => 'bearer']);
   }
   public function logout()
   {
         $payload = JWTAuth::parseToken()->getPayload();
         $userId = $payload->get('sub');
         $user = User::findOrFail($userId);
         JWTAuth::invalidate(JWTAuth::getToken());
         Log::channel('logout')->info('یوزر خارج شد', [
            'user_id' => $user["id"],
            'phone' => $user->phone,
            'ip' => request()->ip()
       ]);
   }
}
