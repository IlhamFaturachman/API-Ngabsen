<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\student;
use App\Models\teacher;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function create(Request $request)
    {
        $input = $request->only('id_number');

        $user = $request->only('name', 'phone', 'address', 'email', 'class', 'student_number');

        $input['password'] = md5($request->password);

        $input['role'] = !$request->role ? 'siswa' : $request->role;

        $create = User::create($input);

        if (!$create) {
            return response([
                'message' => 'Data Cant Be Processed'
            ]);
        }

        if ($input['role'] === 'guru') {

            $teacher_input = $request->only('name', 'email', 'phone', 'address');

            $teacher_input['user_id'] = $create->id;

            $insert = teacher::create($teacher_input);
        }
        if ($input['role'] === 'siswa') {

            $user['user_id'] = $create->id;

            $insert = student::create($user);
        }

        return response([
            'message' => 'Data Inserted'
        ]);
    }

    function getAll(Request $request)
    {
        $data_students = User::with('student')->where('role', 'siswa')->get();

        $data_teacher = User::with('teacher')->where('role', 'guru')->get();

        return response([
            'siswa' => $data_students,
            'guru' => $data_teacher,
        ]);
    }

    function delete(Request $request)
    {
        $id = $request->only('id');

        $user = User::where('id', $id)->first();

        if (!$user) {
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
