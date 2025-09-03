<?php

use Illuminate\Support\Facades\Route;
use Modules\Airport\Http\Controllers\AirportController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('airports', AirportController::class)->names('airport');
});
