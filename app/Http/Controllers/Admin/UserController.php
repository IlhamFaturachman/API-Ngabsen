<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\student;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function create(Request $request){
        $input = $request->only('id_number');

        $user = $request->only('name' , 'phone' , 'address' , 'email' , 'class' , 'student_number');

        $input['password'] = md5($request->password);

        $input['role'] = 'siswa';

        $create = User::create($input);

        if (!$create){
            return response([
                'message' => 'Data Cant Be Processed'
            ]);
        }

        $user['user_id'] = $create->id;

        $student = student::create($user);

        return response([
            'message' => 'Data Inserted'
        ]);
    }

    function getAll(Request $request) {
        $data = User::with('student')->where('role', 'siswa')->get();

        return response($data);
    }

    function delete(Request $request){
        $id = $request->only('id');

        $user = User::where('id', $id)->first();

        if (!$user){
            return response([
                'message' => 'Data Cant Be Processed'
            ]);
        }

        $delete = $user->delete();

        return response([
            'message' => 'Data Deleted'
        ]);
    }
}
