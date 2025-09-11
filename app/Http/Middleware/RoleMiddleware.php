<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
       try {
        $userRoleId = JWTAuth::parseToken()->getPayload()->get('role');
        
        $userRole = $this->mapRole($userRoleId);        

        if (!in_array($userRole, explode('|', $role)))
        {
            return response()->json([], 403);
        }
        
        return $next($request);

       } catch(\Exception $e){
           return response()->json([], 401);
       }
    }
    private function mapRole($roleId)
    {
        $roleMap = [
           1 => 'companyAdmin',
           2 => 'companyOwner',
           3 => 'admin',
           4 => 'owner',
           5 => 'support'
        ];
        return $roleMap[$roleId];
    }
}
