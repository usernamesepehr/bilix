<?php

use Illuminate\Support\Facades\Route;
use Modules\Airport\Http\Controllers\AirportController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('airports', AirportController::class)->names('airport');
});
