<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\attendance_list;
use App\Models\student;
use Illuminate\Http\Request;

class QrController extends Controller
{
    function insert(Request $request){
        $request->validate([
            'teacher_id' => 'required',
            'title' => 'required',
            'subject_id' => 'required',
            'class_id' => 'required',
            'date' => 'required| dateFormat:Y-m-d',
            'open_time' => 'required| dateFormat:Y-m-d H:i:s',
            'closed_time' => 'required | dateFormat:Y-m-d H:i:s',
            'qr_value' => 'required',
            // 'image' => 'required'
        ]);

        $input = $request->only('teacher_id' , 'title' , 'subject_id' , 'class_id' , 'date' , 'open_time' , 'closed_time' , 'qr_value');
        $input['status'] = 'available';

        // $file = $request->file('image');
        // $ext = ['jpg' , 'png' , 'jpeg'];
        // $file_ext = $file->getClientOriginalExtension();

        // if (!in_array($file_ext , $ext)){
        //     return response([
        //         'message' => 'File Extension Must jpg/png/jpeg'
        //     ] , 400);
        // }

        // $filename = date('Y-m-d H-i-s')."_".$file->getClientOriginalName();
        // $file->move(public_path()."/qr/" , $filename);
        // $input['image'] = $filename;

        $create = attendance_list::create($input);

        if (!$create){
            return response([
                'message' => 'Data Cannot Be Processed'
            ]);
        }

        return response([
            'message' => 'Data Inserted'
        ]);
    }

    function changeStatusById(Request $request , $id){
        $request->validate([
            'status' => 'required'
        ]);

        $data = attendance_list::where('id' , $id)->first();

        $data->status = $request->status;
        $data->save();

        return response([
            'message' => 'Status Changed'
        ]);
    }
}
