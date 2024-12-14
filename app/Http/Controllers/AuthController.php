<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\UserRole;
use App\Models\UserRoleMap;

class AuthController extends Controller
{
    public function register(Request $request){
        try {   
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'type' => 'required|in:user,professional'
            ]);
            $user = Users::create($request->all());
            switch($request->type){
                case 'user':
                    $role = UserRole::where("role_name", "=", "user")->first();
                    break;
                case 'professional':
                    $role = UserRole::where("role_name", "=", "professional")->first();                   
                    break;
            }
            if(!empty($role->id)){
                $rolemap = new UserRoleMap();
                $rolemap->user_id=$user->id;
                $rolemap->user_role_id=$role->id;
                $rolemap->save();
            }

            $token = $user->createToken($request->name);

            return response()->json([
                'user' => $user,
                'token' => $token->plainTextToken
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors());
        }
    }
    public function login(Request $request){
        try {
            $fields = $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required'
            ]);
            
            $user = Users::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->password, $user->password)){
                asd;
            }
            $expiresAt = new \DateTime();
            $expiresAt->modify("+8 hours");

            $token = $user->createToken('auth_token', ['*'], $expiresAt);
            $rights=null;
            if(!empty($user->roles)){
                foreach($user->roles as $rolemap){
                    $rights[]=$rolemap->role->role_name;
                }
            }
            $userdata=['id'=>$user->id, 'name'=>$user->name, 'email'=>$user->email, 'roles'=>$rights];
            $return = ['user' => $userdata,'token' =>$token->plainTextToken];
            return response()->json($return);
        } catch (ValidationException $e) {
            return response()->json($e->errors());
        }
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json("kilépve");
    }
}
