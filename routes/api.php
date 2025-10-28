<?php

use App\Http\Controllers\TaskGroupController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FocusTimerController;
use Illuminate\Support\Facades\Route;

Route::resource('task-groups', TaskGroupController::class);

Route::resource('tasks', TaskController::class);

Route::resource('focus-timer', FocusTimerController::class);
