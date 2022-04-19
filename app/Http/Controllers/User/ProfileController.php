<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\student;
use App\Models\teacher;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    function editProfile(Request $request , $user_id){
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'image' => 'required',
        ]);

        $input = $request->only('name', 'phone');
        $file = $request->file('image');

        $ext = ['jpg' , 'png' , 'jpeg'];
        $file_ext = $file->getClientOriginalExtension();
        if (!in_array($file_ext , $ext)){
            return response([
                'message' => 'File Extension Must jpg/png/jpeg'
            ] , 400);
        }

        $update = student::where('user_id' , $user_id)->first();
        if (empty($update)) {
            $update = teacher::where('user_id' , $user_id)->first();
        }

        $filename = $input['name']."_".$file->getClientOriginalName();
        if ($update->image){
            unlink(public_path()."/images/".$update->image);
        };
        $file->move(public_path()."/images/" , $filename);
        $update->update([
            'name' => $input['name'],
            'phone' => $input['phone'],
            'image' => $filename,
        ]);
        $update->save();

        return response([
            'message' => 'Data Updated'
        ]);
    }
}
