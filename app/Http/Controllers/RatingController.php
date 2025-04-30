<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    public function addRating(Request $request){
        $rating = new Rating();
        $rating->user_id = $request->user_id;
        $rating->professional_id = $request->professional_id;
        $rating->description = $request->description;
        $rating->save();

        if($rating){
            return response()->json("rating added successfully");
        } else {
            return respone()->json("something went wrong");
        }
    }
    public function getRatings($id){
        $result = DB::select("SELECT * from ratings where professional_id = ?", [$id]);
        return response()->json($result);
    }
}
