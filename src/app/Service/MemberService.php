<?php 
namespace App\Service;

use App\Repositories\MemberRepositoryInterface;
class MemberService {
    public $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->$memberRepository;
    }

    public function getMember($fixtureInfo){
        $hometeamName = $fixtureInfo[0]['hometeam_name'];
        $awayteamName = $fixtureInfo[0]['awayteam_name'];
        $hometeamPlayers = $this->memberRepository->getMember($fixtureId, $hometeamName);
        $awayteamPlayers = $this->memberRepository->getMember($fixtureId, $awayteamName); 
    }
    
}