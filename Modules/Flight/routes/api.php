<?php

use Illuminate\Support\Facades\Route;
use Modules\Flight\Http\Controllers\FlightController;

Route::prefix('v1')->group(function() {
    Route::prefix('flights')->group(function() {
        Route::post('/', [FlightController::class, 'create'])->middleware('role:companyOwner|companyAdmin');
    });
});
