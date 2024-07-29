<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutorRestController;

Route::prefix('autor')->group(function () {
    Route::any('/index',[AutorRestController::class,'index']);
    Route::get('/show/{id}',[AutorRestController::class,'show']);
    Route::post('/store',[AutorRestController::class,'store']);
    Route::put('/update/{id}',[AutorRestController::class,'update']);
    Route::delete('/destroy/{id}',[AutorRestController::class,'destroy']);
});