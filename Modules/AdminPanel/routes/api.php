<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminPanel\Http\Controllers\AdminPanelController;
use Modules\AdminPanel\Http\Controllers\AirportController;
use Modules\AdminPanel\Http\Controllers\CompanyController;
use Modules\AdminPanel\Http\Controllers\UserController;

Route::prefix('v1')->group(function() {
    Route::prefix('admin')->group(function() {
       Route::prefix('company')->group(function() {
           Route::post('/', [CompanyController::class, 'create'])->middleware('role:owner');
           Route::post('/update', [CompanyController::class, 'update'])->middleware('role:owner');
           Route::delete('/{id}', [CompanyController::class, 'delete'])->middleware('role:owner');
       });
       Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'create'])->middleware('role:admin|owner');
        Route::get('/', [UserController::class, 'findAll'])->middleware('role:admin|owner');
        Route::get('/{id}', [UserController::class, 'findOne'])->middleware('role:admin|owner');
        Route::delete('/{id}', [UserController::class, 'delete'])->middleware('role:admin|owner');
       });
       Route::prefix('airports')->group(function() {
        Route::post('/', [AirportController::class, 'create'])->middleware('role:admin|owner');
        Route::delete('/{id}', [AirportController::class, 'delete'])->middleware('role:admin|owner');
        Route::put('/', [AirportController::class, 'update'])->middleware('role:admin|owner');
       });
    });
    Route::get('airports/', [AirportController::class, 'findAll']);

});
