<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

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
    function listallusers($id=null){
        if ($id) {
            $users = User::find($id);
            if (!$users) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json($user);
        } else {
            return response()->json(User::all());
        }
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
        $user = User::where('id', $id)->first();
        if($user){
            return response()->json($user);
        } else {
            return response()->json("hiba a gépezetben");
        }
        
    }
    public function userTypes(){
        $result = DB::select("
        SELECT
            SUM(CASE WHEN isProfessional = 0 AND isAdmin = 0 THEN 1 ELSE 0 END) AS regular_users,
            SUM(CASE WHEN isProfessional = 1 AND isAdmin = 0 THEN 1 ELSE 0 END) AS professionals,
            SUM(CASE WHEN isProfessional = 0 AND isAdmin = 1 THEN 1 ELSE 0 END) AS admins,
            SUM(CASE WHEN isProfessional = 1 AND isAdmin = 1 THEN 1 ELSE 0 END) AS admin_professionals
        FROM users");

        $counts = [
            $result[0]->regular_users,
            $result[0]->professionals,
            $result[0]->admins,
            $result[0]->admin_professionals
        ];

        return response()->json($counts);
    }
}
