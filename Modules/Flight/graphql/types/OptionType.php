<?php

namespace Modules\Flight\graphql\types;

use GraphQL\Type\Definition\Type;
use Modules\Flight\Models\Option;
use Rebing\GraphQL\Support\Type as GraphQLType;

class OptionType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Option',
        'model' => Option::class
    ];
    public function fields(): array
    {
        return [
            'id' => ['type' => Type::nonNull(Type::int())],
            'type' => ['type' => Type::nonNull(Type::string())],
            'title' => ['type' => Type::nonNull(Type::string())]
        ];
    }
}