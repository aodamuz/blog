<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Resources\PostController;

Route::get('dashboard', DashboardController::class)->name('dashboard');

Route::group(['prefix' => 'resources'], function() {
    Route::resource('posts', PostController::class, ['except' => ['show']]);
});
