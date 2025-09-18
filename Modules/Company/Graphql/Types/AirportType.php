<?php

namespace Modules\Company\Graphql\Types;

use GraphQL\Type\Definition\Type;
use Modules\Company\Models\Airport;
use Rebing\GraphQL\Support\Type as GraphQlType;

class AirportType extends GraphQlType
{
    protected $attributes = [
        'name' => 'Airport',
        'model' => Airport::class
    ];
    public function fields(): array
    {
        return [
            'id' => ['type' => Type::nonNull(Type::int())],
            'name' => ['type' => Type::nonNull(Type::string())],
            'iata' => ['type' => Type::nonNull(Type::string())],
            'slug' => ['type' => Type::nonNull(Type::string())],
            'created_at' => ['type' => Type::nonNull(Type::string())]
        ];
    }
}
