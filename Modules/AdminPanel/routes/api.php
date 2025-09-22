<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminPanel\Http\Controllers\AdminPanelController;
use Modules\AdminPanel\Http\Controllers\CompanyController;

Route::prefix('v1')->group(function() {
    Route::prefix('admin')->group(function() {
       Route::prefix('company')->group(function() {
           Route::post('/', [CompanyController::class, 'create'])->middleware('role:owner');
           Route::post('/update', [CompanyController::class, 'update'])->middleware('role:owner');
           Route::delete('/{id}', [CompanyController::class, 'delete'])->middleware('role:owner');
       });
    });
});
