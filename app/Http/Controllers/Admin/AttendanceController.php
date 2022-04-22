<?php

namespace App\Http\Controllers\Teacher;

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
    function getAttendances(Request $request, $user_id){
        $data = teacher::with('attendance_list')->where('user_id' , $user_id)->get();
        
        return response([
            'data' => $data
        ]);
    }
}
