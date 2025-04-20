<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\UserRole;
use App\Models\UserRoleMap;

class AuthController extends Controller
{
    public function register(Request $request){
        try {   
            $request->validate([
                'surname' => 'required|max:255',
                'firstname' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'phoneNumber' => 'required|max:255',
                'password' => 'required',
            ]);
            //$user = User::create($request->all());

            $user = User::create([
                'surname' => $request->surname,
                'firstname' => $request->firstname,
                'email' => $request->email,
                'phoneNumber' => $request->phoneNumber,
                'isProfessional' => $request->isProfessional ?? false,
                'isAdmin' => $request->isAdmin ?? false,
                'password' => Hash::make($request->password),
                
            ]);
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

            $token = $user->createToken($request->surname);

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
            
            $user = User::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->password, $user->password)){
                asd;
            }
            $expiresAt = new \DateTime();
            $expiresAt->modify("+8 hours");

            $token = $user->createToken('auth_token', ['*'], $expiresAt);
            
            if ($user->isAdmin && $user->isProfessional) {
                $right = 'admin-professional';
            } elseif ($user->isAdmin) {
                $right = 'admin';
            } elseif ($user->isProfessional) {
                $right = 'professional';
            } else {
                $right = 'user';
            }
            
            $userdata=['id'=>$user->id, 'surname'=>$user->surname, 'firstname'=>$user->firstname, 'email'=>$user->email, 'role'=>$right];
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
