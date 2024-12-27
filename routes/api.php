<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\AttendanceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// login
Route::post('/user/login', [UserController::class, 'login']);

// check email
Route::post('/user/check-email', [UserController::class, 'checkEmail'])->middleware('auth:sanctum');

// get user
Route::get('/user/{email}', [UserController::class, 'index']);

// logout
Route::post('/user/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// get all user
Route::get('/users', [UserController::class, 'getAllUser'])->middleware('auth:sanctum');

// schedule
Route::get('/schedule', [ScheduleController::class, 'index'])->middleware('auth:sanctum');

// attendance - store
Route::post('/attendance', [AttendanceController::class, 'store'])->middleware('auth:sanctum');

// attendance - update
Route::put('/attendance', [AttendanceController::class, 'update'])->middleware('auth:sanctum');

Route::get('/images/{filename}', [UserController::class, 'getImage']);

Route::get('/schedule/get-today', [ScheduleController::class, 'getScheduleByDate'])->middleware('auth:sanctum');

Route::get('/attendance/check-in-status', [AttendanceController::class, 'checkCheckInToday'])->middleware('auth:sanctum');

Route::get('/attendance/get-attendance-history', [AttendanceController::class, 'getAllAttendanceHistory'])->middleware('auth:sanctum');

Route::get('/images/{filename}', [UserController::class, 'getImage']);
