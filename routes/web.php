<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;




Route::get('/dashboard', [Dashboard::class,'dashboard'])->name('dashboard');



Route::prefix('user')->group(function () {

    Route::any('/index',[UserController::class,'index'])->name('user.index');
    Route::get('/create',[UserController::class,'create'])->name('user.create');
    Route::get('/edit/{id}',[UserController::class,'edit'])->name('user.edit');
    Route::get('/show/{id}',[UserController::class,'show'])->name('user.show');
    Route::get('/delete/{id}',[UserController::class,'delete'])->name('user.delete');

    Route::post('/store',[UserController::class,'store'])->name('user.store');
    Route::put('/update/{id}',[UserController::class,'update'])->name('user.update');
    Route::delete('/destroy/{id}',[UserController::class,'destroy'])->name('user.destroy');
});