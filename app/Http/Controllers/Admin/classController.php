<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\classes;
use Illuminate\Http\Request;

class classController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'grade' => 'required',
            'major_id' => 'required',
            'class' => 'required',
        ]);

        $input = $request->only('grade' , 'major_id' , 'class');

        $input['grade'] = strtoupper($input['grade']);

        $input['class'] = strtoupper($input['class']);

        $create = classes::create($input);

        if(!$create){
            return response([
                'message' => 'Data Cannot Be Processed'
            ] , 400);
        }

        return response([
            'message' => 'Data Inserted'
        ]);
    }

    public function delete(Request $request , $id){
        $data = classes::destroy($id);

        if(!$data){
            return response([
                'message' => 'No Data With Id'
            ] , 400);
        }

        return response([
            'message' => 'data deleted'
        ]);
    }

    public function getData(){
        $data = classes::with('major')->orderBy('grade')->get();

        $dataClasses = [];

        

        return response([

            'data' => $data
        ]);
    }
}
