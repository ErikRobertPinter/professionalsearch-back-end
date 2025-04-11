<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;

class SkillController extends Controller
{
    public function getSkills(Request $request)
    {

        $profession = urldecode($request->profession);
        $settlement = urldecode($request->settlement);
        $skills = User::orderBy("surname");
        if(!empty($request->profession)){
            $profession = $request->profession;
            $skills->whereHas('professionals', function($subQuery) use($profession) {
                $subQuery->where('profession_name', 'like', "%".$profession . "%");
            });
        }
        if (!empty($request->settlement)) {
            $settlement = $request->settlement;
            $skills->whereHas('settlements', function ($subQuery) use ($settlement) {
                $subQuery->where('settlement_name', 'like', "%" . $settlement . "%");
            });
        }
        $return = $skills->get();
        return response()->json($return);
        
    }
}