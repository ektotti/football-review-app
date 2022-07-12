<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('schedule:test')
        ->everyFiveMinutes()
        ->timezone('ASIA/TOKYO')
        ->between('11:00','18:00');

        $schedule->command('get:fixturesInfo')
        ->monthlyOn(1, '1:00');

        $schedule->command('get:lineup')
        ->everyThirtyMinutes()
        ->timezone('ASIA/TOKYO')
        ->between('11:00','22:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
