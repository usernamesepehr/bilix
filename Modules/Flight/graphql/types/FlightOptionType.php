<?php

namespace Modules\Flight\graphql\types;

use GraphQL\Type\Definition\Type;
use Modules\Flight\Models\Flight_option;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class FlightOptionType extends GraphQLType
{
    protected $attributes = [
        'name' => 'FlightOption',
        'model' => Flight_option::class
    ];
    public function fields(): array
    {
        return [
            'id' => ['type' => Type::nonNull(Type::int())],
            'quantity' => ['type' => Type::nonNull(Type::int())],
            'options_id' => ['type' => Type::listOf(Type::int())],
            'price' => ['type' => Type::nonNull(Type::string())],
            'option_objects' => ['type' => Type::listOf(GraphQL::type('Option'))]
        ];
    }
}