<?php

use App\Http\Controllers\Admin\TrainingCrudController;
use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('student', 'StudentCrudController');
    Route::crud('training', 'TrainingCrudController');
    Route::crud('schedule', 'ScheduleCrudController');
    Route::crud('nutritional-plan', 'NutritionalPlanCrudController');
    Route::crud('attendance', 'AttendanceCrudController');
    Route::crud('training-progress', 'TrainingProgressCrudController');
}); // this should be the absolute last line of this file

Route::get('training/fetch/student', [TrainingCrudController::class, 'fetchStudent']);

/**
 * DO NOT ADD ANYTHING HERE.
 */
