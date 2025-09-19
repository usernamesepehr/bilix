<?php

use Illuminate\Support\Facades\Route;
use Modules\Company\Models\Rate;
use Modules\Flight\Http\Controllers\FlightController;
use Modules\Flight\Http\Controllers\FlightOptionController;
use Rebing\GraphQL\GraphQLController;

Route::prefix('v1')->group(function() {
    Route::prefix('flights')->group(function() {
        Route::post('/', [FlightController::class, 'create'])->middleware('role:companyOwner|companyAdmin');
        Route::get('/' , [GraphQLController::class, 'query']);
        Route::get('/{slug}', [FlightController::class, 'findOne']);
        Route::delete('/{id}', [FlightController::class, 'delete'])->middleware('role:companyOwner|companyAdmin');
        Route::put('/' , [FlightController::class, 'update'])->middleware('role:companyOwner|companyAdmin');
        Route::prefix('options')->group(function () {
            Route::post('/', [FlightOptionController::class, 'create'])->middleware('role:companyOwner|companyAdmin');
            Route::delete('/{id}', [FlightOptionController::class, 'delete'])->middleware('role:companyOwner|companyAdmin');
        });
    });
});
