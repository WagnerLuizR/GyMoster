<?php

use App\Http\Controllers\Web\AutorController;
use App\Http\Controllers\Web\Dashboard;
use Illuminate\Support\Facades\Route;




Route::get('/dashboard', [Dashboard::class,'dashboard'])->name('dashboard');



Route::prefix('autor')->group(function () {

    Route::any('/index',[AutorController::class,'index'])->name('autor.index');
    Route::get('/create',[AutorController::class,'create'])->name('autor.create');
    Route::get('/edit/{id}',[AutorController::class,'edit'])->name('autor.edit');
    Route::get('/show/{id}',[AutorController::class,'show'])->name('autor.show');
    Route::get('/delete/{id}',[AutorController::class,'delete'])->name('autor.delete');

    Route::post('/store',[AutorController::class,'store'])->name('autor.store');
    Route::put('/update/{id}',[AutorController::class,'update'])->name('autor.update');
    Route::delete('/destroy/{id}',[AutorController::class,'destroy'])->name('autor.destroy');
});