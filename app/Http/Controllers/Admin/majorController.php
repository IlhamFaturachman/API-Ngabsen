<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\major;
use Illuminate\Http\Request;

class majorController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'name' => 'required'
        ]);

        $input = $request->only('name');

        $input['name'] = strtoupper($input['name']);

        $create = major::create($input);

        if(!$create){
            return response([
                'message' => 'Data Cannot Be Inserted'
            ]);
        }

        return response([
            'message' => 'Data Inserted'
        ]);
    }

    public function delete(Request $request , $id){
        $delete = major::destroy($id);

        if(!$delete){
            return response([
                'message' => 'No Data With ID'
            ] , 400);
        }

        return response([
            'message' => 'Data Deleted'
        ]);
    }

    public function getData(){
        $data = major::orderBy('name')->get();

        return response([
            'data' => $data
        ]);
    }
}
