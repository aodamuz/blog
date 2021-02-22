<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('dashboard', DashboardController::class)->name('dashboard');

Route::resource('posts', PostController::class);
