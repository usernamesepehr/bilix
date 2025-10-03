<?php 

namespace Modules\Flight\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterService {
    protected Request $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function filters(): array
    { 
        return [
            'origin'      => fn ($q, $v) => $q->where('origin_airport', $v),
            'destination' => fn ($q, $v) => $q->where('destination_airport', $v),
            'date'        => fn ($q, $v) => $q->where('date', $v),

            'price_min'   => fn ($q, $v) => $q->whereHas('FlightOptions', fn($sub) => $sub->where('price', '>=', $v)),
            'price_max'   => fn ($q, $v) => $q->whereHas('FlightOptions', fn($sub) => $sub->where('price', '<=', $v)),
         ];
    }
    public function apply(Builder $query): Builder
    {
         $filters = $this->filters();
         foreach ($filters as $key  => $callback){
            if ($this->request->filled($key)) {
                $callback($query, $this->request->get($key));
            }
         }
        $query->withMin('FlightOptions', 'price');
        return $query->orderBy('flight_options_min_price', $this->request->get('sort') ?? 'asc');
    }
}