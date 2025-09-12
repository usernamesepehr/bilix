<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AdminLoginController;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\OtpController;

Route::prefix('v1')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/refresh', [Authcontroller::class, 'refresh']);
        Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    });
    Route::prefix('otp')->group(function () {
        Route::get('/', [OtpController::class, 'generate'])->name('otp-generate');
        Route::post('/', [OtpController::class, 'check'])->name('otp-check');
    });
    Route::post('/login/admin', [AdminLoginController::class, 'login'])->middleware('auth:api');
});
