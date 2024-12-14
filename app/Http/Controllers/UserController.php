<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    function add(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $result = $user->save();

        if($result){
            return ["Result"=>"User has been saved."];
        } else {
            return ["Result"=>"User has not been saved."];
        }
    }
    function list($id=null){
        return $id?User::find($id):User::all();
    }
    function delete($id){
        $user = User::find($id);
        $result=$user->delete();
        if($result){
            return ["Result"=>"User has been deleted."];
        } else {
            return ["Result"=>"User has not been deleted."];
        }
    }

    function index(){
        echo "hello";
        exit;
    }
}
