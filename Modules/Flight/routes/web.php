<?php

use Illuminate\Support\Facades\Route;
use Modules\Flight\Http\Controllers\FlightController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('flights', FlightController::class)->names('flight');
});
