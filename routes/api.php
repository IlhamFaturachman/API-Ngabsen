<?php

use App\Http\Controllers\Admin\classController;
use App\Http\Controllers\Admin\majorController;
use App\Http\Controllers\Admin\subjectController;
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

    Route::get('/subject' , [subjectController::class , 'getData']);

    Route::name('admin')->prefix('/admin')->group(function(){
        Route::post('/subject' , [subjectController::class , 'create']);
        Route::delete('/subject/{id}' , [subjectController::class , 'delete']);
        Route::get('/subject' , [subjectController::class , 'getData']);

        Route::post('/class' , [classController::class , 'create']);
        Route::delete('/class/{id}' , [classController::class , 'delete']);
        Route::get('/class' , [classController::class , 'getData']);
        
        Route::post('/major' , [majorController::class , 'create']);
        Route::delete('/major/{id}' , [majorController::class , 'delete']);
        Route::get('/major' , [majorController::class , 'getData']);
    });

    // Student
    Route::put('/student/updateProfile/{user_id}' , [\App\Http\Controllers\User\ProfileController::class , 'editProfile']);
    Route::get('/student/attendanceHistory/{id}', [\App\Http\Controllers\User\AttendanceController::class, 'getAttendanceHistory']);
    Route::post('/attendance', [\App\Http\Controllers\User\AttendanceController::class, 'attendance'])->middleware('QR');

    // Teacher
    Route::post('/teacher/createQr', [\App\Http\Controllers\Teacher\QrController::class, 'insert']);
    Route::get('/teacher/attendanceDetail/{id}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'getAttendanceDetails']);
    Route::get('/teacher/attendances/{id}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'getAttendances']);
    Route::put('/updateQr/{id}', [\App\Http\Controllers\Teacher\QrController::class, 'changeStatusById']);

    // Admin
    Route::post('/admin/userCreate' , [\App\Http\Controllers\Admin\UserController::class , 'create']);
    Route::post('/admin/userEdit/{id}' , [\App\Http\Controllers\Admin\UserController::class , 'edit']);
    Route::post('/admin/userDelete', [\App\Http\Controllers\Admin\UserController::class, 'delete']);
    Route::get('/admin/userGetAll', [\App\Http\Controllers\Admin\UserController::class, 'getAll']);
    Route::get('/admin/getStudentAttendances', [\App\Http\Controllers\Admin\AttendanceController::class, 'getStudentAttendances']);
});
