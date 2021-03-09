<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('dashboard', DashboardController::class)->name('dashboard');

Route::post('upload', [UploadController::class, '__invoke'])->name('upload');

Route::group(['prefix' => 'resources'], function() {
    Route::resource('posts', PostController::class, ['except' => ['show']]);
});
