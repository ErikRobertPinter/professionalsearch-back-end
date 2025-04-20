<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Job;


class JobController extends Controller
{
    function add(Request $request){
        try {
            $job = new Job();
            $job->title=$request->title;

            if ($request->hasFile('image')) {
                $imageName = $request->file('image')->hashName();
                Storage::disk('local')->put($imageName, file_get_contents($request->file('image')));
                $job->image = $imageName; // ha van ilyen meződ
            }
            
            $job->address=$request->address;
            $job->customer=$request->customer;
            $job->income=$request->income;
            $job->cost=$request->cost;

            $job->profit = $job->income-$job->cost;
            $job->user_id=$request->userId;
            $result=$job->save();
        } catch(\Exception $e) {
            return response()->json($e);
        }
        
    }

    function list($id=null){
        return $id?Job::find($id):Job::all();
    }

    function myJobs($userId) {
        return Job::where('user_id', $userId)->get()->toJson();
    }

    public function monthlyStatistics($userId, $year){
        /*$monthlyStatistics = DB::select("SELECT count(*) FROM jobs j join users u on jobs.userId = users.id where u.id = ? and year(j.created_at) = ? and month(j.created_at) = ?", [$userId, $year, $month]);
        return response()->json($monthlyStatistics);*/

        $results = DB::select("
        SELECT 
            MONTH(j.created_at) as month, 
            COUNT(*) as job_count 
        FROM jobs j 
        JOIN users u ON j.user_id = u.id 
        WHERE u.id = ? AND YEAR(j.created_at) = ? 
        GROUP BY MONTH(j.created_at)
    ", [$userId, $year]);

    // Alapértelmezetten minden hónap 0
    $monthlyCounts = array_fill(1, 12, 0);

    foreach ($results as $row) {
        $monthlyCounts[$row->month] = $row->job_count;
    }

    // Ha nulladik indextől szeretnéd (index 0 -> január), akkor:
    $monthlyCounts = array_values($monthlyCounts);

    return response()->json(array_values($monthlyCounts));
    }

    public function monthlyProfits($userId, $year){
        $results = DB::select("
        SELECT 
            MONTH(j.created_at) as month, 
            SUM(j.profit) as total_profit
        FROM jobs j 
        JOIN users u ON j.user_id = u.id 
        WHERE u.id = ? AND YEAR(j.created_at) = ? 
        GROUP BY MONTH(j.created_at)
    ", [$userId, $year]);

    // Minden hónapra alapból 0 profit
    $monthlyProfits = array_fill(1, 12, 0);

    foreach ($results as $row) {
        $monthlyProfits[$row->month] = (float) $row->total_profit;
    }

    // 0-indexű array-t csinálunk belőle (január = 0)
    $monthlyProfits = array_values($monthlyProfits);

    return response()->json($monthlyProfits);
    }
}