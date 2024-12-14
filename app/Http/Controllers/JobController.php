<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    function add(Request $request){
        $job = new Job();
        $job->title=$request->title;
        $job->address=$request->address;
        $job->customer=$request->customer;
        $job->income=$request->income;
        $job->cost=$request->cost;
        $result=$job->save();
        if($result){
            return ['Result'=>'Job has been saved'];
        } else {
            return ['Result'=>'Job is not saved.'];
        }
    }

    function list($id=null){
        return $id?Job::find($id):Job::all();
    }
}
