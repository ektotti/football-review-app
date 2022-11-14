<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\FixtureResource;
use App\Service\FixtureService;
use Illuminate\Support\Facades\Log;
use App\Fixture;

class FixtureController extends Controller
{
    public function __construct(FixtureService $fixtureService)
    {
        $this->fixtureService = $fixtureService;
    }

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

    public function getWithMember(Request $request) {
        return new FixtureResource($this->fixtureService->getByid($request->fixture_id));
    }
}
