<?php

namespace Modules\Flight\graphql\types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class FlightPaginationType extends GraphQLType
{
    protected $attributes = [
        'name' => 'FlightPagination'
    ];

    public function fields(): array
    {
        return [
            'data' => ['type' => Type::listOf(GraphQL::type('Flight'))],
            'current_page' => ['type' => Type::int()],
            'last_page' => ['type' => Type::int()],
            'per_page' => ['type' => Type::int()],
            'total' => ['type' => Type::int()],
        ];
    }
}
