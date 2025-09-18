<?php

use Illuminate\Support\Facades\Route;
use Modules\Flight\Http\Controllers\FlightController;
use Rebing\GraphQL\GraphQLController;

Route::prefix('v1')->group(function() {
    Route::prefix('flights')->group(function() {
        Route::post('/', [FlightController::class, 'create'])->middleware('role:companyOwner|companyAdmin');
        Route::get('/' , [GraphQLController::class, 'query']);
    });
});
