<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\attendance;
use App\Models\attendance_list;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    function getAttendanceHistory(Request $request, $user_id){
        $data = attendance::with('attendance_list')->where('student_id' , $user_id)->get();
        
        return response([
            'data' => $data
        ]);
    }
    
    function attendance(Request $request){
        $request->validate([
            'student_id' => 'required',
            'attendance_time' => 'required| dateFormat:Y-m-d H:i:s',
        ]);

        $input = $request->only('student_id' , 'attendance_time');

        $attendance_id = Auth::guard('qr')->id();

        $time = Auth::guard('qr')->user()->closed_time;

        $input['attendance_id'] = $attendance_id;

        if (Carbon::parse($time) >= Carbon::parse($input['attendance_time'])){
            $input['status'] = 'onTime';
        }else{
            $input['status'] = 'late';
        }

        $create = attendance::create($input);

        if (!$create){
            return response([
                'message' => 'Data Cannot Be Processed'
            ]);
        }

        $data = attendance::with('student' , 'attendance_list.teacher')->where('id' , $create->id)->first();

        return response([
            'data' => $data
        ]);
    }
}
