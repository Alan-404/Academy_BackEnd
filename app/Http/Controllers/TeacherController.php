<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Teacher;

class TeacherController extends Controller
{
    //
    public function getAll(){
        try{
            $teachers = Teacher::all();

            return ["teachers"=>$teachers];
        }
        catch(Exception $e){
            return ["message"=>$e];
        }
    }

    public function insertTeacher(Request $request){

        if (!$request->firstName || !$request->lastName || !$request->phone || !$request->email)
            return ["success"=>false];
        try{
            $result = DB::insert('insert into teacher (firstName, middleName, lastName, bDate, address, phone, email) values (?,?,?,?,?,?,?)', [$request->firstName, $request->middleName, $request->lastName, $request->bDate, $request->address, $request->phone, $request->email]);

            if (!$result)
                return ["success"=>false];
            return ["success"=>true];
        }
        catch(Exception $e){
            return ["success"=>false, "message"=>$e];
        }  
    }

}
