<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('autor')->group(function () {
    Route::any('/index',[UserController::class,'index']);
    Route::get('/show/{id}',[UserController::class,'show']);
    Route::post('/store',[UserController::class,'store']);
    Route::put('/update/{id}',[UserController::class,'update']);
    Route::delete('/destroy/{id}',[UserController::class,'destroy']);
});