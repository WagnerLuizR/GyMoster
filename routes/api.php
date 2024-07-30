<?php

use App\Http\Controllers\CoachController;
use Illuminate\Support\Facades\Route;

Route::prefix('coach')->group(function () {
    Route::any('/index', [CoachController::class, 'index']);
    Route::get('/show/{id}', [CoachController::class, 'show']);
    Route::post('/store', [CoachController::class, 'store']);
    Route::put('/update/{id}', [CoachController::class, 'update']);
    Route::delete('/destroy/{id}', [CoachController::class, 'destroy']);
});
