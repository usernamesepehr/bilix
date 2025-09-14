<?php

namespace Modules\Flight\graphql\types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Modules\Flight\Models\Flight;
use Rebing\GraphQL\Support\Facades\GraphQL;

class FlightType extends GraphQLType
{
    protected $attributes = [
        'name' => 'company',
        'model' => Flight::class
    ];

    public function fields(): array
    {
        return [
            'id' => ['type' => Type::nonNull(Type::int())],
            'load' => ['type' => Type::nonNull(Type::int())],
            'number' => ['type' => Type::nonNull(Type::string())],
            'plane' => ['type' => Type::nonNull(Type::string())],
            'discount' => ['type' => Type::int()],
            'origin' => ['type' => GraphQL::type('Airport')],
            'destination' => ['type' => GraphQL::type('Airport')],
            'company' => ['type' => GraphQL::type('Company')],
            'slug' => ['type' => Type::nonNull(Type::string())],
            'date' => ['type' => Type::nonNull(Type::string())],
            'timeStart' => ['type' => Type::nonNull(Type::string())],
            'timeEnd' => ['type' => Type::nonNull(Type::string())],
            'options' => ['type' => GraphQL::type('FlightOption')]
        ];
    }
}