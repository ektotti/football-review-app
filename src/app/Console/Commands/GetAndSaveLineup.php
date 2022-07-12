<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Fixture;
use App\Member;
use App\UseCase\GetLineupUseCase;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetAndSaveLineup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:lineup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            Member::where('player_1', null)->delete();

            $searchFrom = new Carbon('now');
            Log::debug('cron:'.$searchFrom);
            // dd($searchFrom);
            $searchTo = new Carbon('+90 minutes');
            // dd($searchTo);

            $fixtures = Fixture::where('fixture_date_time', '>', $searchFrom)->where('fixture_date_time', '<', $searchTo)->get();

            // dd($fixtures);
            $fixtures = $fixtures->toArray();
            if ($fixtures) {
                foreach ($fixtures as $key => $fixture) {

                    if (Member::where('fixture_id', $fixture['id'])->where('team_name', $fixture['hometeam_name'])->first()) {
                        continue;
                    }

                    $homeTeamLineup = Member::create([
                        'fixture_id' => $fixture['id'],
                        'team_name' => $fixture['hometeam_name'],
                        'status' => 'home',
                    ]);

                    $awayTeamLineup = Member::create([
                        'fixture_id' => $fixture['id'],
                        'team_name' => $fixture['awayteam_name'],
                        'status' => 'away',
                    ]);

                    $matchUrl = $fixture['fixture_url'];
                    $playerNameLists = GetLineupUseCase::run($matchUrl . '#live');

                    $homeTeamLineup->fill($playerNameLists[0])->save();
                    $awayTeamLineup->fill($playerNameLists[1])->save();

                    DB::commit();
                    sleep(10);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            report($e->getMessage());
            Artisan::call('get:lineup');
        }
    }
}
