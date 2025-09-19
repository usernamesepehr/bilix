<?php

namespace Modules\Flight\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Flight\Http\Requests\createFlightOptionRequest;
use Modules\Flight\Models\Flight_option;

class FlightOptionController extends Controller
{
    public function create(createFlightOptionRequest $request): void
    {
        Flight_option::createOption($request, $request->flight_id);
    }
    public function delete(int $id): void
    {
        Flight_option::deleteOption($id);
    }
}
