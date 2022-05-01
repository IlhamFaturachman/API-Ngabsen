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
            $student_input = $request->only('name', 'phone', 'address', 'email', 'class', 'student_number');

            $student_input['user_id'] = $create->id;

            $insert = student::create($student_input);
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
    
    function edit(Request $request, $id)
    {
        $input = $request->only('id_number', 'password', 'role');

        if (!empty($input['password'])) {
            $input['password'] = md5($input['password']);
        }

        if (!empty($input)) {
            $update = User::find($id)->update($input);
        }

        if (!$update) {
            return response([
                'message' => 'Data Cant Be Processed',
                'id' => $id,
                'data' => $input,
            ]);
        }

        if (!empty($input['role'])) {
            if ($input['role'] === 'guru') {
                $teacher_input = $request->only('name', 'email', 'phone', 'address');
    
                if (!empty($student_input)) {
                    $updateTeacher = teacher::where('user_id', $id)->update($teacher_input);
                }
            }
            if ($input['role'] === 'siswa') {
                $student_input = $request->only('name', 'phone', 'address', 'email', 'class', 'student_number');
    
                if (!empty($student_input)) {
                    $updateStudent = student::where('user_id', $id)->update($student_input);
                }
            }
        }

        return response([
            'message' => 'Data Inserted',
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
