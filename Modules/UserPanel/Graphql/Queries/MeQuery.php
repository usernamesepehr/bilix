<?php

namespace Modules\UserPanel\Graphql\Queries;

use GraphQL\Type\Definition\Type;
use Modules\Auth\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Tymon\JWTAuth\Facades\JWTAuth;

class MeQuery extends Query
{
   protected $attributes = [
        'name' => 'me',
    ];

    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function resolve()
    {
        $userId = JWTAuth::parseToken()->getPayload()->get('id');
        $user = User::with('company')->findOrFail($userId);

        $user->role = $this->mapRole($user->role);
        return $user;
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
