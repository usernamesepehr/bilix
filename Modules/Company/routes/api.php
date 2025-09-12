<?php

use Illuminate\Support\Facades\Route;
use Modules\Company\Http\Controllers\AirportController;
use Modules\Company\Http\Controllers\CertificateController;
use Modules\Company\Http\Controllers\CompanyController;

Route::prefix('v1')->group(function() {
    Route::prefix('company')->group(function() {
        Route::prefix('airports')->group(function() {
            Route::post('/{airportId}', [AirportController::class, 'create'])->middleware('role:companyAdmin|companyOwner');
            Route::get('/', [AirportController::class, 'findAll'])->middleware('role:companyAdmin|companyOwner');
            Route::delete('/{airportId}', [AirportController::class, 'delete'])->middleware('role:companyAdmin|companyOwner');
        });
        Route::prefix('certificates')->group(function() {
            Route::post('/', [CertificateController::class, 'create'])->middleware('role:companyAdmin|companyOwner');
            Route::get('/', [CertificateController::class, 'findAll'])->middleware('role:companyAdmin|companyOwner');
            Route::delete('/{certificateId}', [CertificateController::class, 'delete'])->middleware('role:companyAdmin|companyOwner');
        });
        Route::prefix('personnels')->group(function() {
            Route::post('/', ); 
        });
    });
});
