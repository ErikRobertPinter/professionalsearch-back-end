<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class UserController extends Controller
{
    function add(Request $request){
        $user = new User();
        $user->surname = $request->surname;
        $user->firstname = $request->firstname;
        $user->email = $request->email;
        $user->phoneNumber = $request->phoneNumber;
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

    public function getUserById($id){
        /*$user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user);*/

        $user = Users::where('id', $id)->first();
        if($user){
            return response()->json($user);
        } else {
            return response()->json("hiba a gépezetben");
        }
        
    }
}
