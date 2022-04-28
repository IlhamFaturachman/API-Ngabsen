<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\attendanceResource;
use App\Models\attendance;
use App\Models\attendance_list;
use App\Models\student;
use App\Models\teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    function getStudentAttendances(Request $request){
        $data = attendance::with('attendance_list')->get();
        
        return response([
            'data' => $data
        ]);
    }
}
