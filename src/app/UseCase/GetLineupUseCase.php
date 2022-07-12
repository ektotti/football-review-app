<?php 
namespace App\UseCase;
use Nesk\Puphpeteer\Puppeteer;

class GetLineupUseCase
{
    static public function run($matchUrl)
    {
    
        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch([ 'args' => ['--no-sandbox', '--disable-setuid-sandbox']]);

        $page = $browser->newPage();

        $page->setViewport([
            'width'  => 1080,
            'height' => 4000
        ]);
        $page->setDefaultNavigationTimeout(0); 
        $page->goto($matchUrl);
        $page->waitForTimeout(20000);
        
        $memberlists = $page->querySelectorAll('section.matchMemberArea .MemberList');
        
        $playerNameLists = [];

        $homeTeamPlayerName = [];
        foreach($memberlists[0]->querySelectorAll('li') as $key => $val) {
            if($val->querySelector('.ListName')){
                $PlayerName = $val->querySelector('.ListName')->getProperty('textContent')->jsonValue();
                $PlayerName .= $val->querySelector('.ListNumber')->getProperty('textContent')->jsonValue();
                $homeTeamPlayerName["player_{$key}"] = $PlayerName;
            }
        };
        foreach($memberlists[2]->querySelectorAll('li') as $key => $val) {
            if($val->querySelector('.ListName')){
                $PlayerName = $val->querySelector('.ListName')->getProperty('textContent')->jsonValue();
                $PlayerName .= $val->querySelector('.ListNumber')->getProperty('textContent')->jsonValue();
                $keyNum = $key + 11;
                $homeTeamPlayerName["player_{$keyNum}"] = $PlayerName;
            }
        };
        $playerNameLists[] = $homeTeamPlayerName;
        
        $awayTeamPlayerName = [];
        foreach($memberlists[1]->querySelectorAll('li') as $key => $val) {
            if($val->querySelector('.ListName')){
                $PlayerName = $val->querySelector('.ListName')->getProperty('textContent')->jsonValue();
                $PlayerName .= $val->querySelector('.ListNumber')->getProperty('textContent')->jsonValue();
                $awayTeamPlayerName["player_{$key}"] = $PlayerName;
            }
        };
        foreach($memberlists[3]->querySelectorAll('li') as $key => $val) {
            if($val->querySelector('.ListName')){
                $PlayerName = $val->querySelector('.ListName')->getProperty('textContent')->jsonValue();
                $PlayerName .= $val->querySelector('.ListNumber')->getProperty('textContent')->jsonValue();
                $keyNum = $key + 11;
                $awayTeamPlayerName["player_{$keyNum}"] = $PlayerName;
            }
        };
        $playerNameLists[] = $awayTeamPlayerName;

        $browser->close();

        return $playerNameLists;
    }
}
?>