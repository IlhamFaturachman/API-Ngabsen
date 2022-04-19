<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
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
        $teacher_id = teacher::select('id')->where('user_id', $user_id)->first();
        $data = attendance_list::where('teacher_id', $teacher_id['id'])->get();
        
        return response([
            'data' => $data
        ]);
    }

    function getAllStudent(Request $request, $attendance_id){
        $attendances = attendance::where('attendance_id', $attendance_id)->get();

        foreach ($attendances as $key => $value) {
            $student = student::where('user_id', $value->user_id)->first();
            $data[$key] = [
                "name" => $student->name,
                "time" => $value->attendance_time,
                "status" => $value->status,
            ];
        }
        
        return response([
            'data' => $data
        ]);
    }

    function getAttendanceDetails(Request $request, $attendance_id) {
        $attendees = attendance::where('attendance_id', $attendance_id)->get();
        $attendance = attendance_list::where('id', $attendance_id)->first();

        $onTime = 0;
        $late = 0;
        $other = 0;
        foreach ($attendees as $key => $value) {
            if ($value->status == 'onTime') {
                $onTime++;
            } else if ($value->status == 'late') {
                $late++;
            } else {
                $other++;
            }
        }

        $statuses = [
            'onTime' => $onTime,
            'late' => $late,
            'other' => $other,
        ];

        $attendance['statuses'] = $statuses;

        return response([
            'data' => $attendance
        ]);
    }
}
