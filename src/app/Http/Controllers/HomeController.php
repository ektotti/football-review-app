<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fixture;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $tagName = $request->tag_name;
        $isIndex = true;
        return view('home', compact('isIndex', 'tagName'));
    }
}
