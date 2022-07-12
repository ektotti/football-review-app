<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\UseCase\GetFixturesInfoUseCase;
use App\Fixture;
use Illuminate\Support\Facades\Log;

class GetAndSaveFixturesInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:fixturesInfo';

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
    public function __construct(GetFixturesInfoUseCase $usecase)
    {
        parent::__construct();
        $this->usecase = $usecase;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $month = Carbon::now()->format('m');
        $fixtures = $this->usecase->run($month);

        foreach ($fixtures as $fixtureInfo) {
            $result = Fixture::where('match_week', $fixtureInfo['match_week'])->where('hometeam_name', $fixtureInfo['hometeam_name'])->get()->toArray();
            if ($result) {
                continue;
            }
            $fixture = new Fixture;
            $resutl = $fixture->fill($fixtureInfo)->save();
        }
    }
}
