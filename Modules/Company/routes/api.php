<?php

use Illuminate\Support\Facades\Route;
use Modules\Company\Http\Controllers\AirportController;
use Modules\Company\Http\Controllers\CertificateController;
use Modules\Company\Http\Controllers\CompanyController;
use Modules\Company\Http\Controllers\PersonnelController;
use Predis\Configuration\Option\Prefix;

Route::prefix('v1')->group(function() {
    Route::prefix('company')->group(function() {
        Route::prefix('me')->group(function () {
            Route::get('/', [CompanyController::class, 'get'])->middleware('role:companyAdmin|companyOwner');
            Route::put('/', [CompanyController::class, 'update'])->middleware('role:companyAdmin|companyOwner');
        });
        Route::prefix('airports')->group(function() {
            Route::post('/{airportId}', [AirportController::class, 'create'])->middleware('role:companyAdmin|companyOwner');
            Route::get('/', [AirportController::class, 'findAll'])->middleware('role:companyAdmin|companyOwner');
            Route::delete('/{airportId}', [AirportController::class, 'delete'])->middleware('role:companyAdmin|companyOwner');
        });
        Route::prefix('certificates')->group(function() {
            Route::post('/', [CertificateController::class, 'create'])->middleware('role:companyOwner');
            Route::get('/', [CertificateController::class, 'findAll'])->middleware('role:companyOwner');
            Route::delete('/{certificateId}', [CertificateController::class, 'delete'])->middleware('role:companyOwner');
        });
        Route::prefix('personnels')->group(function() {
            Route::post('/', [PersonnelController::class, 'create'])->middleware('role:companyOwner');
            Route::get('/', [PersonnelController::class, 'findAll'])->middleware('role:companyOwner');
            Route::get('/{id}', [PersonnelController::class,'findOne'])->middleware('role:companyOwner');
            Route::delete('/{id}', [PersonnelController::class, 'delete'])->middleware('role:companyOwner'); 
        });
    });
});
