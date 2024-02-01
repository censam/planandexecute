<?php

namespace App\Console;

use App\Console\Commands\DueObjectives;
use App\Console\Commands\DueScorecards;
use App\Console\Commands\ScorecardRunner;
use App\Console\Commands\UnreadChat;
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
        DueObjectives::class,
        // ScorecardRunner::class,
        // DueScorecards::class,
        UnreadChat::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('email:due-objectives')->daily();
        // $schedule->command('scorecard:runner')->daily();
        // $schedule->command('scorecard:due-scorecards')->daily();
        $schedule->command('unread-chat:email')->daily();
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
