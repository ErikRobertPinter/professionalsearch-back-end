<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Job;

class JobController extends Controller
{
    function add(Request $request){
        try {
            $job = new Job();
            $job->title=$request->title;

            $imageName = $request->file('image')->hashName();
            Storage::disk('local')->put($imageName, file_get_contents($request->file('image')));
            
            $job->address=$request->address;
            $job->customer=$request->customer;
            $job->income=$request->income;
            $job->cost=$request->cost;

            $job->profit = $job->income-$job->cost;
            $job->userId=$request->userId;
            $result=$job->save();
        } catch(\Exception $e) {
            return response()->json($e);
        }
        
    }

    function list($id=null){
        return $id?Job::find($id):Job::all();
    }

    function myJobs($userId) {
        return Job::where('userid', $userId)->get()->toJson();
    }
}
