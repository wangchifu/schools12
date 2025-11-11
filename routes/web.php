<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class,'index'])->name('index');
Route::get('index/{area?}/{school_type?}', [HomeController::class,'index'])->name('index_select');
Route::get('teacher/{area?}/{school_type?}', [HomeController::class,'teacher'])->name('teacher_select');
Route::get('student/{area?}/{school_type?}', [HomeController::class,'student'])->name('student_select');
Route::get('refresh', [HomeController::class,'refresh'])->name('refresh');