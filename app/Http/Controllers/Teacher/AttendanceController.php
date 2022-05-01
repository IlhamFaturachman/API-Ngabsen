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

    function getAttendanceDetails(Request $request, $attendance_id) {
        $data = attendance::with('student')->where('attendance_id' , $attendance_id)->get();

        $late = [];

        $onTime = [];

        $permit = [];

        foreach ($data as $key => $value){
            if($value->status === 'late'){
                array_push($late , $value);
            }if($value->status === 'onTime'){
                array_push($onTime , $value);
            }if($value->status === 'permit'){
                array_push($permit , $value);
            }
        }

        return response([
            'data' => $data,
            'data_count' => count($data),
            'late' => count($late),
            'onTime' => count($onTime),
            'permit' => count($permit),
        ]);
    }

    public function changeAttendanceStatus(Request $request , $id){
        $data = attendance::where('id' , $id)->first();

        if(!$data){
            return response([
                'message' => 'No Data With Id'
            ] , 401);
        }

        $data->status = 'permit';

        $data->save();

        return response([
            'message' => 'success'
        ]);
    }
}
