<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Account;

use JWTAuth;

class AccountController extends Controller
{
    //

    public function insertAccount(Request $request){
        if (!$request->username || !$request->password)
            return ["success"=> false, "message"=>"Missing information"];
        try{
            $hashPassword = Hash::make($request->password);

            $result = DB::insert('insert into account (username, password) values (?,?)', [$request->username, $hashPassword]);
            $result = Account::create($request->all());
            if (!$result)
                return ["success"=> false];

            return ["success"=>true];
        }
        catch(Exception $e){
            return ["success"=>false, "message"=>$e];
        }
    }

    public function getAll(){
        try{
            $accounts = Account::all();
            return ["account"=>$accounts];
        }
        catch(Exception $e){
            return ["message"=>$e];
        }
    }

    public function loginAccount(Request $request){
        if (!$request->username || !$request->password)
            return ["success"=> false, "message"=>"Missing information"];

        try{
            $getAccount = DB::select('select * from account where username = ?', [$request->username]);

            if (sizeof($getAccount) != 1)
                return ["success"=>false];
            
            $account = $getAccount[0];

            $checkPassword = Hash::check($request->password,$account->PASSWORD);


            

            if (!$checkPassword)
                return ["success"=>false];
            $accessToken = Crypt::encryptString($account->ID);
            return ["success"=>true, "accessToken"=>$accessToken];
        }
        catch(Exception $e){
            return ["success"=>false, "message"=>$e];
        }
    }

    public function changePassword(Request $request){
        $headerAuthorization = $request->header('Authorization');

        $token = explode(" ", $headerAuthorization)[1];

        if (!$token)
            return ["success"=>false];

        try{
            $accountId = Crypt::decryptString($token);
            $getAccount = DB::select('select * from account where id = ?', [$accountId]);

            $account = $getAccount[0];
            $checkPassword = Hash::check($request->oldPassword, $account->PASSWORD);
            if (!$checkPassword)
                return ["success"=>false];

            $hashPassword = Hash::make($request->newPassword);
            $result = DB::update('update account set password = ? where id = ?', [$hashPassword, $accountId]);

            if (!$result)
                return ["success"=>false];
            return ["success"=>true];
        }
        catch(Exception $e){
            return ["success"=>false, "message"=>$e];
        }
    }


    public function auth(Request $request){
        $headerAuthorization = $request->header('Authorization');

        $token = explode(" ", $headerAuthorization)[1];

        $id = Crypt::decryptString($token);

        return ["test"=>$id];
    }
}
