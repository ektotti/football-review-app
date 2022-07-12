<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fixture;
use Illuminate\Support\Facades\Log;

class FixtureController extends Controller
{
    public function getRecentFixtures()
    {
        $recentFixtures = Fixture::getRecentFixtures();
        foreach ($recentFixtures as $key => $value) {
            $recentFixtures[$key] = str_replace("http", "https", $value);
        }

        return $recentFixtures;
    }
    
    public function getComingSoonFixtures()
    {
        $comingSoonFixtures = Fixture::getComingSoonFixtures();
        foreach ($comingSoonFixtures as $key => $value) {
            $comingSoonFixtures[$key] = str_replace("http", "https", $value);
        }
        return $comingSoonFixtures;
    }
}
