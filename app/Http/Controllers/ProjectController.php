<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        return response()->json([
            'data'    =>    Project::all()
        ], 200);
    }

    public function store(Request $request){
        
    }

    public function show($id){

    }


    public function update(Request $request, $id){

    }

    public function destroy($id){

    }
}
