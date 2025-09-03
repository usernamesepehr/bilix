<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminPanel\Http\Controllers\AdminPanelController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('adminpanels', AdminPanelController::class)->names('adminpanel');
});
