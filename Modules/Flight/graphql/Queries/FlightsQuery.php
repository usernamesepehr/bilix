<?php

namespace Modules\Flight\graphql\Queries;

use GraphQL\Type\Definition\Type;
use Modules\Flight\Models\Flight;
use Modules\Flight\Models\Option;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class FlightsQuery extends Query
{
    protected $attributes = [
        'name' => 'Flights'
    ];

    public function type(): Type
    {
        return GraphQL::paginate('Flight');
    }

    public function args(): array
    {
        return [
            'limit' => [
                'type' => Type::int(),
                'description' => 'Number of items per page',
                'defaultValue' => 10
            ],
            'page' => [
                'type' => Type::int(),
                'description' => 'Page number',
                'defaultValue' => 1
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $Flights = Flight::with(['origin', 'destination', 'company', 'FlightOptions'])->paginate($args['limit'], ['*'], 'page', $args['page']);
        
        // $Flights->getCollection()->transform(function($Flight) {
        //     $Flight->options->transform(function($FlightOption) {
        //         $FlightOption->option_objects = Option::where('id', $FlightOption->options_id)->get();
        //         return $FlightOption;
        //     });
        //     return $Flight;
        // });
        return $Flights;
    }
}