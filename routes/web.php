<?php

use App\Http\Controllers\CoachController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [Dashboard::class, 'dashboard'])->name('dashboard');

Route::prefix('user')->group(function () {
    Route::any('/index', [UserController::class, 'index'])->name('user.index');
    Route::get('/show/{id}', [UserController::class, 'show'])->name('user.show');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::prefix('coach')->group(function () {
    Route::any('/index', [CoachController::class, 'index']);
    Route::get('/show/{id}', [CoachController::class, 'show']);
    Route::post('/store', [CoachController::class, 'store']);
    Route::put('/update/{id}', [CoachController::class, 'update']);
    Route::delete('/destroy/{id}', [CoachController::class, 'destroy']);
});
