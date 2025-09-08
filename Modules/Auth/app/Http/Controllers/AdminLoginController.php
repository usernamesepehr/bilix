<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Auth\Http\Requests\AdminLoginRequest;
use Modules\Auth\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminLoginController extends Controller
{
    public function login(AdminLoginRequest $request)
    {
        $payload = JWTAuth::parseToken()->getPayload();
        $userId = $payload->get('id');
        $user = User::findOrFail($userId);
        $userRole = $this->mapRole($user->role);
        if ($request->role !== $userRole){
            return response()->json([], 403);
        }
        JWTAuth::invalidate(JWTAuth::getToken());
        $newToken = JWTAuth::claims(['id' => $user->id, 'role' => $user->role])->fromUser($user);

        $this->logLogin($user, $userRole);
        
        return response()->json(['token' => $newToken, 'type' => 'bearer']);
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
    private function logLogin($user, $userRole)
    {
        Log::channel('login')->info("$userRole لاگین کرد", [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $userRole,
            'ip' => request()->ip(),
        ]);
    }
}
