<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Can;
use Modules\Auth\Http\Requests\OtpRequest;
use Modules\Auth\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class OtpController extends Controller
{
    public function generate(OtpRequest $request)
    {
         $otp = random_int(10000, 99999);
        Cache::put($request->email, $otp, 180);
        Mail::raw("کد شما : $otp", function ($message) use ($request) {
              $message->to($request->email)
              ->subject('کد تأیید');
        });

    }
    public function check(OtpRequest $request)
    {
        $otp = Cache::get($request->email);
        if (!$otp || $otp != $request->otp){
            return response()->json([], 401);
        }
        $user = User::getByEmail($request->email);
        $token = JWTAuth::claims(['id' => Auth::id()])->fromUser(Auth::user());

        $this->logLogin($user);

        return response()->json(['token' => $token, 'type' => 'bearer']);
    }
    private function logLogin($user)
    {
        Log::channel('login')->info('یوزر لاگین کرد!', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => request()->ip(),
        ]);
    }
}
