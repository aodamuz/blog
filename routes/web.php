<?php

use App\Http\Controllers\PostController;

Route::view('/', 'welcome');

Route::view('/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => 'auth'], function() {
    Route::resource('posts', PostController::class);
});
