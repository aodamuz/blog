<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Resources\PostController;
use App\Http\Controllers\Admin\Resources\RestorePostController;
use App\Http\Controllers\Admin\Resources\ForceDeletePostController;

Route::get('dashboard', DashboardController::class)->name('dashboard');

Route::group(['prefix' => 'resources'], function() {
    Route::delete('posts/{post}/delete', ForceDeletePostController::class)->name('posts.delete');
    Route::patch('posts/{post}/restore', RestorePostController::class)->name('posts.restore');
    Route::resource('posts', PostController::class, ['except' => ['show']]);
});
