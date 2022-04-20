<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('ngabsen')->group(function (){
    Route::post('/login' , [\App\Http\Controllers\Auth\AuthController::class , 'login']);

    // Student
    Route::put('/updateProfile/{user_id}' , [\App\Http\Controllers\User\ProfileController::class , 'editProfile']);
    Route::get('/student/attendanceHistory/{id}', [\App\Http\Controllers\User\AttendanceController::class, 'getAttendanceHistory']);
    Route::post('/attendance', [\App\Http\Controllers\User\AttendanceController::class, 'attendance'])->middleware('QR');

    // Teacher
    Route::post('/teacher/createQr', [\App\Http\Controllers\Teacher\QrController::class, 'insert']);
    Route::get('/teacher/studentAttendance/{id}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'getAllStudent']);
    Route::get('/teacher/attendanceDetail/{id}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'getAttendanceDetails']);
    Route::get('/teacher/attendances/{id}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'getAttendances']);
    Route::put('/updateQr/{id}', [\App\Http\Controllers\Teacher\QrController::class, 'changeStatusById']);

    // Admin
    Route::post('/admin/userCreate' , [\App\Http\Controllers\Admin\UserController::class , 'create']);
    Route::post('/admin/userDelete', [\App\Http\Controllers\Admin\UserController::class, 'delete']);
    Route::get('/admin/userGetAll', [\App\Http\Controllers\Admin\UserController::class, 'getAll']);
    Route::post('/admin/studentCreate' , [\App\Http\Controllers\Admin\StudentController::class , 'create']);
    Route::post('/admin/studentDelete', [\App\Http\Controllers\Admin\StudentController::class, 'delete']);
    Route::get('/admin/studentGetAll', [\App\Http\Controllers\Admin\StudentController::class, 'getAll']);
});
