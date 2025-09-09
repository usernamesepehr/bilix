<?php

namespace Modules\Company\Graphql\Types;

use GraphQL\Type\Definition\Type;
use Modules\Company\Models\Company;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CompanyType extends GraphQLType
{
     protected $attributes = [
        'name'          => 'Company',
        'model'         => Company::class
    ];

    public function fields(): array
    {
        return [
            'id' => ['type' => Type::nonNull(Type::int())],
            'name' => ['type' => Type::nonNull(Type::string())],
            'description' => ['type' => Type::nonNull(Type::string())],
            'registerNumber' => ['type' => Type::nonNull(Type::string())],
            'address' => ['type' => Type::nonNull(Type::string())],
            'slug' => ['type' => Type::nonNull(Type::string())],
            'logo' => ['type' => Type::string()],
            'created_at' => ['type' => Type::nonNull(Type::string())]
        ];
    }
}