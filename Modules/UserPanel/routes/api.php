<?php

use Illuminate\Support\Facades\Route;
use Modules\UserPanel\Http\Controllers\UserPanelController;
use Rebing\GraphQL\GraphQLController;

Route::prefix('v1')->group(function () {
    Route::post('/me', [GraphQLController::class, 'query'])->middleware('auth:api');
});


