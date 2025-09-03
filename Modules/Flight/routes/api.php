<?php

use Illuminate\Support\Facades\Route;
use Modules\Flight\Http\Controllers\FlightController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('flights', FlightController::class)->names('flight');
});
