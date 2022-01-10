<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Lesson;

class LessonController extends Controller
{
    //

    public function getAll(){
        try{
            $lessons = Lesson::all();

            return ["lessons"=>$lessons];
        }
        catch(Exception $e){
            return ["message"=> $e];
        }
    }

    public function insertLesson(Request $request){
        if (!$request->id || !$request->timeStart || !$request->timeEnd)
            return ["success"=>false, "message"=>"Missing information"];

        try{
            $checkId = DB::select('select * from lesson where id = ?', [$request->id]);
            if (sizeof($checkId) != 0)
                return ["success"=>false, "message"=>"Lesson matched"];

            $result = DB::insert('insert into lesson values (?,?,?)', [$request->id, $request->timeStart, $request->timeEnd]);
            if (!$result)
                return ["success"=>false];
            return ["success"=>true];
        }
        catch(Exception $e){
            return ["success"=>false, "message"=>$e];
        }
    }

    public function editLesson(Request $request){
        if (!$request->id)
            return ["success"=>false];

        try{
            $result = DB::update('update lesson set timeStart = ?, timeEnd = ? where id = ?', [$request->timeStart, $request->timeEnd, $request->id]);

            if (!$result)
                return ["success"=>false];
            return ["success"=>true];
        }
        catch(Exception $e){
            return ["success"=>false, "message"=>$e];
        }
    }


    public function deleteLesson(Request $request){
        $id = $request->query('id');

        if (!$id)
            return ["success"=>false];

        try{
            $result = DB::delete('delete from lesson where id = ?', [$id]);

            if (!$result)
                return ["success"=>false];
            return ["success"=>true];
        }
        catch(Exception $e){
            return ["success"=>false, "message"=>$e];
        }
    }
}
