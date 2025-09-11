<?php

use Illuminate\Support\Facades\Route;
use Modules\UserPanel\Http\Controllers\UpdateMeController;
use Modules\UserPanel\Http\Controllers\UserPanelController;
use Rebing\GraphQL\GraphQLController;

Route::prefix('v1')->group(function () {
    Route::get('/me', [GraphQLController::class, 'query'])->middleware('auth:api');
    Route::post('/me', UpdateMeController::class)->middleware('auth:api');
});


