<?php

use Illuminate\Database\Seeder;

class FixturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fixtures = factory(App\Fixture::class, 60)->create()
            ->each(function ($fixture) {
                
                factory(App\Member::class)
                ->make(["fixture_id" => $fixture->id, 'team_name' => $fixture->hometeam_name, 'status' => 'home'])
                ->save();
               
                factory(App\Member::class)
                ->make(["fixture_id" => $fixture->id, 'team_name' => $fixture->awayteam_name, 'status' => 'away'])
                ->save();
            });
    }
}
