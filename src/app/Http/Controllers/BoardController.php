<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Fixture;

class BoardController extends Controller
{
    public function index(Request $request){
        $selectedMatch = Fixture::where('id', $request->id)->get()->toArray();
        $request->session()->put('fixture_id', $request->id);
        return view('board',["selectedMatch"=>$selectedMatch]);
    }
}
