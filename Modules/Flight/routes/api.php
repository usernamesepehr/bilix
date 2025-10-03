<?php

use Illuminate\Support\Facades\Route;
use Modules\Flight\Http\Controllers\FlightController;
use Modules\Flight\Http\Controllers\FlightOptionController;
use Rebing\GraphQL\GraphQLController;

Route::prefix('v1')->group(function() {
    Route::delete('/admin/flights/{id}', [FlightController::class, 'deleteByAdmin'])->middleware('role:admin|owner');
    Route::prefix('flights')->group(function() {
        Route::post('/', [FlightController::class, 'create'])->middleware('role:companyOwner|companyAdmin');
        Route::post('/excel', [FlightController::class, 'createExcel'])->middleware('role:companyOwner|companyAdmin');
        Route::get('/' , [GraphQLController::class, 'query']);
        Route::get('/filter', [FlightController::class, 'findByFilter']);
        Route::get('/{slug}', [FlightController::class, 'findOne']);
        Route::delete('/{id}', [FlightController::class, 'delete'])->middleware('role:companyOwner|companyAdmin');
        Route::put('/' , [FlightController::class, 'update'])->middleware('role:companyOwner|companyAdmin');
        Route::put('/bulk' , [FlightController::class, 'updateMultiple'])->middleware('role:companyOwner|companyAdmin|admin|owner');
        Route::prefix('options')->group(function () {
            Route::post('/', [FlightOptionController::class, 'create']);
            Route::delete('/{id}', [FlightOptionController::class, 'delete']);
        });
    });
});
