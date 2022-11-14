<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Member;
use App\Fixture;
use App\Http\Resources\FixtureResource;
use App\Service\MemberService;
use App\Service\FixtureService;

class GetMemberController extends Controller
{
    public function __invoke(Request $request, MemberService $memberservice, FixtureService $fixtureService){
        $fixtureInfo = new FixtureResource($fixtureService->getById($request->fixture_id));
        $member = $memberservice->getBothMember($fixtureInfo);
        
        return ['hometeamMember'=>$hometeamName, 'awayteamMember'=>$awayteamName];
    }
}
