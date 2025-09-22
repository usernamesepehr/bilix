<?php

namespace Modules\AdminPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdminPanel\Http\Requests\CreateAirportRequest;
use Modules\AdminPanel\Http\Requests\UpdateAirportRequest;
use Modules\Company\Models\Airport;

class AirportController extends Controller
{
    public function create(CreateAirportRequest $request)
    {
        $timestamp = (string) time();
        Airport::createAirport($request, $timestamp);
    }
    public function update(UpdateAirportRequest $request)
    {
        Airport::updateAirport($request);
    }
    public function delete(int $id)
    {
        Airport::where('id', $id)->delete();
    }
    public function findAll()
    {
        $perPage = request()->input('per_page') ?? 20;
        $airports = Airport::paginate($perPage);
        return response()->json(['data' => $airports]);
    }
}
