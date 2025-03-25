<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profession;

class ProfessionController extends Controller
{
    public function addProfession(Request $request){
        $profession = new Profession();
        $profession->userId  = $request->userId;
        $profession->profession_name = $request->profession_name;
        $profession->school = $request->school;
        $profession->description = $request->description;
        $profession->save();
    }
    function myProfessions($userId) {
        //$profession = Profession::where('userId', $userId)->get()->toJson();
        $profession = Profession::where('userId', $userId)->first();
        if($profession){
            return response()->json($profession);
        } else {
            return response()->json("hiba a gépezetben");
        }
        
    }
}
