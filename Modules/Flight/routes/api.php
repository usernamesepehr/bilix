<?php

use Illuminate\Support\Facades\Route;
use Modules\Flight\Http\Controllers\FlightController;
use Rebing\GraphQL\GraphQLController;

Route::prefix('v1')->group(function() {
    Route::prefix('flights')->group(function() {
        Route::post('/', [FlightController::class, 'create'])->middleware('role:companyOwner|companyAdmin');
        Route::get('/' , [GraphQLController::class, 'query']);
        Route::get('/{slug}', [FlightController::class, 'findOne']);
        Route::delete('/{id}', [FlightController::class, 'delete'])->middleware('role:companyOwner|companyAdmin');
    });
});
