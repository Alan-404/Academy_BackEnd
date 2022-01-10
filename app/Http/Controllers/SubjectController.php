<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Subject;


class SubjectController extends Controller
{
    //

    public function insertSubject(Request $request){

        if (!$request->name)
            return ["success"=>false, "message"=>"Missing information"];

        $arr = explode(" ", $request->name);

        $idSubject = '';

        for ($x = 0; $x<sizeof($arr); $x++){
            $idSubject .= $arr[$x][0];
        }

        try{
            $result = DB::insert('insert into subject (id, name) values (?,?)', [$idSubject, $request->name]);

            if (!$result)
                return ["success"=>false];
            return ["success"=>true];

        }
        catch(Exception $e){
            return ["success"=>false, "message"=>$e];
        }
    }


    public function getAll(){
        try{
            $subjects = Subject::all();

            return ["subjects"=>$subjects];
        }
        catch(Exception $e){    
            return ["message"=>$e];
        }
    }
}
