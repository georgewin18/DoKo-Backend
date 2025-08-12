<?php

use App\Http\Controllers\TaskGroupController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('task-groups', TaskGroupController::class);

Route::resource('tasks', TaskController::class);
