<?php

use App\Http\Controllers\Admin\AttendanceCrudController;
use App\Http\Controllers\Admin\NutritionalPlanCrudController;
use App\Http\Controllers\Admin\ScheduleCrudController;
use App\Http\Controllers\Admin\StudentCrudController;
use App\Http\Controllers\Admin\TrainingCrudController;
use App\Http\Controllers\Admin\TrainingProgressCrudController;
use App\Http\Controllers\Admin\UserCrudController;
use App\Http\Controllers\Auth\CsrfTokenController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/   token', CsrfTokenController::class);

Route::get('/', function () {
    return view('welcome');
});

// Rota CRUD para Login
Route::post('login', [LoginController::class, 'login']);
// Rotas CRUD para User
Route::get('user', [UserCrudController::class, 'indexExposed'])->name('user.index');
Route::get('user/{id}', [UserCrudController::class, 'showExposed'])->name('user.show');
Route::post('user', [UserCrudController::class, 'storeExposed'])->name('user.store');
Route::put('user/{id}', [UserCrudController::class, 'updateExposed'])->name('user.update');
Route::delete('user/{id}', [UserCrudController::class, 'destroy'])->name('user.destroy');

// Rotas CRUD para Student
Route::get('student', [StudentCrudController::class, 'indexExposed'])->name('student.index');
Route::get('student/{id}', [StudentCrudController::class, 'showExposed'])->name('student.show');
Route::post('student', [StudentCrudController::class, 'storeExposed'])->name('student.store');
Route::put('student/{id}', [StudentCrudController::class, 'updateExposed'])->name('student.update');
Route::delete('student/{id}', [StudentCrudController::class, 'destroyExposed'])->name('student.destroy');

// Rotas CRUD para Training
Route::get('training', [TrainingCrudController::class, 'indexExposed'])->name('training.index');
Route::get('training/{id}', [TrainingCrudController::class, 'showExposed'])->name('training.show');
Route::post('training', [TrainingCrudController::class, 'storeExposed'])->name('training.store');
Route::put('training/{id}', [TrainingCrudController::class, 'updateExposed'])->name('training.update');
Route::delete('training/{id}', [TrainingCrudController::class, 'destroyExposed'])->name('training.destroy');

// Rotas CRUD para Schedule
Route::get('schedule', [ScheduleCrudController::class, 'indexExposed'])->name('schedule.index');
Route::get('schedule/{id}', [ScheduleCrudController::class, 'showExposed'])->name('schedule.show');
Route::post('schedule', [ScheduleCrudController::class, 'storeExposed'])->name('schedule.store');
Route::put('schedule/{id}', [ScheduleCrudController::class, 'updateExposed'])->name('schedule.update');
Route::delete('schedule/{id}', [ScheduleCrudController::class, 'destroyExposed'])->name('schedule.destroy');

// Rotas CRUD para Nutritional Plan
Route::get('nutritional-plan', [NutritionalPlanCrudController::class, 'indexExposed'])->name('nutritional-plan.index');
Route::get('nutritional-plan/{id}', [NutritionalPlanCrudController::class, 'showExposed'])->name('nutritional-plan.show');
Route::post('nutritional-plan', [NutritionalPlanCrudController::class, 'storeExposed'])->name('nutritional-plan.store');
Route::put('nutritional-plan/{id}', [NutritionalPlanCrudController::class, 'updateExposed'])->name('nutritional-plan.update');
Route::delete('nutritional-plan/{id}', [NutritionalPlanCrudController::class, 'destroyExposed'])->name('nutritional-plan.destroy');

// Rotas CRUD para Attendance
Route::get('attendance', [AttendanceCrudController::class, 'indexExposed'])->name('attendance.index');
Route::get('attendance/{id}', [AttendanceCrudController::class, 'showExposed'])->name('attendance.show');
Route::post('attendance', [AttendanceCrudController::class, 'storeExposed'])->name('attendance.store');
Route::put('attendance/{id}', [AttendanceCrudController::class, 'updateExposed'])->name('attendance.update');
Route::delete('attendance/{id}', [AttendanceCrudController::class, 'destroyExposed'])->name('attendance.destroy');

// Rotas CRUD para Training Progress
Route::get('training-progress', [TrainingProgressCrudController::class, 'indexExposed'])->name('training-progress.index');
Route::get('training-progress/{id}', [TrainingProgressCrudController::class, 'showExposed'])->name('training-progress.show');
Route::post('training-progress', [TrainingProgressCrudController::class, 'storeExposed'])->name('training-progress.store');
Route::put('training-progress/{id}', [TrainingProgressCrudController::class, 'updateExposed'])->name('training-progress.update');
Route::delete('training-progress/{id}', [TrainingProgressCrudController::class, 'destroyExposed'])->name('training-progress.destroy');
