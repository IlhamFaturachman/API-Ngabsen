<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class subjectController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'name' => 'required'
        ]);

        $input = $request->only('name');

        $input['name'] = strtoupper($input['name']);

        $create = Subject::create($input);

        if (!$create) {
            return response([
                'message' => 'Dat Cant Be Inserted'
            ] , 401);
        }

        return response([
            'message' => 'success'
        ]);
    }

    public function delete(Request $request , $id){
        $data = Subject::where('id' , $id)->first();

        if(!$data){
            return response([
                'message' => 'No Data With ID'
            ] , 401);
        }

        $data->delete();

        return response([
            'message' => 'Data deleted'
        ]);
    }

    public function getData(){
        $data = Subject::orderBy('name')->get();

        return response([
            'data' => $data
        ]);
    }
}
