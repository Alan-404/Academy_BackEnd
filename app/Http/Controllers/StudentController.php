<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Student;


class StudentController extends Controller
{
    //

    public function insertStudent(Request $request){
        if (!$request->firstName || !$request->lastName || !$request->phone || !$request->email)
            return ["success"=>false];

        try{
            $result = DB::insert('insert into student (firstName, middleName, lastName, bDate, phone, email) values (?,?,?,?,?,?)', [$request->firstName, $request->middleName, $request->lastName, $request->bDate, $request->phone, $request->email]);

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
            $students = Student::all();

            return ["students"=>$students];
        }
        catch(Exception $e){
            return ["message"=>$e];
        }
    }
}
