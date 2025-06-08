<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\Carbon;

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
            
            $profile_picture_file_name = null;
            if($request->hasFile('profile_picture')){
                $file = $request->file('profile_picture');
                $extension = $file->getClientOriginalExtension();
                $timestamp = Carbon::now()->format('Ymd_His');
                $existingFiles = Storage::files('public/profile_pictures');
                $profilePictureFileName = "{$timestamp}.{$extension}";
                $file->storeAs('public/profile_pictures', $profilePictureFileName);
            }

            $user = User::create([
                'surname' => $request->surname,
                'firstname' => $request->firstname,
                'profile_picture'=>$request->profile_picture_file_name,
                'email' => $request->email,
                'phoneNumber' => $request->phoneNumber,
                'isProfessional' => $request->isProfessional ?? false,
                'isAdmin' => $request->isAdmin ?? false,
                'password' => Hash::make($request->password),
                
            ]);
            $token = $user->createToken($request->surname);

            return response()->json([
                'user' => $user,
                'token' => $token->plainTextToken
            ]);
        } catch (ValidationException $e) {
            return response()->json($e->errors());
        }
    }
    
    public function professionalSignup(Request $request){
        try {
            $data = $request->validate([
                'surname' => 'required',
                'firstname' => 'required',
                'email' => 'required',
                'phoneNumber' => 'required',
                'password' => 'required',
    
                'education' => 'array',
                'education'*'year_from' => 'required',
                'education'*'month_from' => 'required',
                'education'*'year_to' => 'required',
                'education'*'month_to' => 'required',
                'education'*'institution' => 'required',
                'education'*'profession' => 'required',
                'services' => 'array',
                'services'*'service_type' => 'required',
                'services'*'unit_type' => 'required',
                'services'*'service_price' => 'required',
            ]);
        } catch (ValidationException $e){
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
