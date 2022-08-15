<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/players', '\App\Http\Controllers\GetMemberController');
Route::get('/fixture/recent', '\App\Http\Controllers\FixtureController@getRecentFixtures');
Route::get('/fixture/coming_soon', '\App\Http\Controllers\FixtureController@getComingSoonFixtures');
