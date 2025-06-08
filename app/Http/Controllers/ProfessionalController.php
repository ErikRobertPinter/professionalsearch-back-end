<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
    public function getProfessionalDetailsLogined($id){
        $basic_datas = DB::select('select * from users where id = ?', [$id]);
        $education = DB::select('select * from professions where user_id = ?', [$id]);
        $jobs = DB::select('select * from jobs where user_id = ?', [$id]);

        $professional_basic_datas = ['id'=>$basic_data->id, 'surname'=>$basic_data->surname, 'firstname'=>$basic_data->firstname, 'email'=>$basic_data->email, 'phoneNumber'=>$basic_data->phoneNumber];
        $education = ['profession_name'=>$services->profession_name, 'school'=>$services->school, 'description'=>$services->description];
        $jobs_of_professional = ['title'=>$jobs->title, 'date'=>$jobs->created_at];

        $professsional_profile = ['personal_info'=>$professional_basic_datas, 'education'=> $education, 'jobs'=>$jobs];

        return response()->json($professsional_profile);
    }
}
