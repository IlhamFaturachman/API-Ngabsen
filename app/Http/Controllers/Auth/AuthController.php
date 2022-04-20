<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login(Request $request) {
        $request->validate([
            'id_number' => 'required',
            'password' => 'required'
        ]);

        $input = $request->only('id_number' , 'password');

        $input['password'] = md5($input['password']);

        $user = User::where('id_number', $input['id_number'])->where('password', $input['password'])->first();

        if (!$user){
            return response([
                'message' => 'Id or Password is Incorrect'
            ],400);
        }

        if ($user->role === 'siswa'){
            $data_user = User::with('student')->where('id_number', $input['id_number'])->where('password', $input['password'])->first();
        }
        if ($user->role === 'guru'){
            $data_user = User::with('teacher')->where('id_number', $input['id_number'])->where('password', $input['password'])->first();
        }

        return response([
            'data' => $data_user
        ]);
    }
}
