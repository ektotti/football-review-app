<?php 
namespace App\UseCase;

use Illuminate\Support\Facades\Log;
use Nesk\Puphpeteer\Puppeteer;

class GetFixturesInfoUseCase
{
    public function run($month)
    {
        $puppeteer = new Puppeteer;
        $browser = $puppeteer->launch([ 'args' => ['--no-sandbox', '--disable-setuid-sandbox']]);

        $page = $browser->newPage();
        $page->goto("https://www.jleague.jp/match/search/?category%5B%5D=j1&year=2022&month%5B%5D={$month}");
        
        $fixtures = [];
        foreach ($page->querySelectorAll('section.contentBlock section.matchlistWrap') as $element) {
            $kickoffDate = formatDate($element->querySelector('div.timeStamp h4.leftRedTit')->getProperty('textContent')->jsonValue());
            $matchweek = $element->querySelector('.leagAccTit h5')->getProperty('textContent')->jsonValue();
            preg_match("/[0-9]+/", $matchweek, $m);
            $matchweekNum = $m[0];
                foreach($element->querySelectorAll('table.matchTable>tbody>tr') as $matchtable ){
                    $matchurl = $matchtable->querySelector('td.match a')->getProperty('href')->jsonValue();
                    
                    $urlArray = array_column($fixtures, 'matchurl');
                    if(array_search($matchurl, $urlArray)) {
                        continue;
                    }
                    $hometeamName = $matchtable->querySelector('td.clubName.leftside')->getProperty('textContent')->jsonValue();
                    $hometeamName = str_replace(array(" ", "\r\n", "\r", "\n"), '', $hometeamName);
                    $awayteamName = $matchtable->querySelector('td.clubName.rightside')->getProperty('textContent')->jsonValue();
                    $awayteamName = str_replace(array(" ", "\r\n", "\r", "\n"), '', $awayteamName);
                    $kickoffTime = formatTime($matchtable->querySelector('td.stadium')->getProperty('textContent')->jsonValue());
                    
                    $fixtures[] = [
                        'match_week' => $matchweekNum,
                        'hometeam_name' => $hometeamName,
                        'awayteam_name' => $awayteamName,
                        'fixture_date_time' => $kickoffDate.' '.$kickoffTime,
                        'fixture_url' => $matchurl,
                    ];
                }    
        }
        $browser->close();
        return $fixtures;
    }
}
?>