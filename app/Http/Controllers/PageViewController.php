<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageView;

class PageViewController extends Controller
{
    function addPageView(Request $request){
        $pageView = new PageView();
        $pageView->pagename = $request->pagename;
        $result=$pageView->save();
        
        if($result){
            return ["Result"=>"Data has been saved."];
        } else {
            return ["Result" => "Open failed."];
        }
    }
}
