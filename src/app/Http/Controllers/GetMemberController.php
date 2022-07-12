<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Member;
use App\Fixture;
use Illuminate\Support\Facades\Log;

class GetMemberController extends Controller
{
    public function __invoke(Request $request){
        $fixtureId = $request->fixture_id;
        Log::debug($fixtureId);
        // dd($fixtureId);
        $fixtureInfo = Fixture::where('id',$fixtureId)->get()->toArray();
        // dd($fixtureInfo[0]['id']);
        Log::debug($fixtureInfo);
        $hometeamName = $fixtureInfo[0]['hometeam_name'];
        $awayteamName = $fixtureInfo[0]['awayteam_name'];
        $hometeamPlayers = Member::getSeparetedNameAndNumber($fixtureInfo[0]['id'], $fixtureInfo[0]['hometeam_name']);
        $awayteamPlayers = Member::getSeparetedNameAndNumber($fixtureInfo[0]['id'], $fixtureInfo[0]['awayteam_name']);
        $players = [
            'hometeamPlayers'=>$hometeamPlayers,
            'awayteamPlayers'=>$awayteamPlayers,
        ];
        return ['hometeamName'=>$hometeamName, 'awayteamName'=>$awayteamName, 'players'=>$players];
    }
}
