<?php

namespace Modules\UserPanel\Graphql\Types;

use GraphQL\Type\Definition\Type;
use Modules\Auth\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'User',
        'model'         => User::class
    ];

    public function fields(): array
    {
        return [
            'name' => ['type' => Type::nonNull(Type::string())],
            'phone' => ['type' => Type::nonNull(Type::string())],
            'email' => ['type' => Type::nonNull(Type::string())],
            'city' => ['type' => Type::nonNull(Type::string())],
            'profile' => ['type' => Type::string()],
            'melli' => ['type' => Type::string()],
            'role' => ['type' => Type::nonNull(Type::string())],
            'company' => ['type' => GraphQL::type('Company')],
            'created_at' => ['type' => Type::nonNull(Type::string())]
        ];
    }
}