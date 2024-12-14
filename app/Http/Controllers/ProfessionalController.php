<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;

class ProfessionalController extends Controller
{
    function add(Request $request){
        $professional = new Professional();
        $professional->surname = $request->surname;
        $professional->firstname = $request->firstname;
        $professional->email = $request->email;
        $result=$professional->save();
        
        if($result){
            return ["Result"=>"Data has been saved."];
        } else {
            return ["Result" => "Open failed."];
        }
    }
}
