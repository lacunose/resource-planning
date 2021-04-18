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
        Commands\NakoaV1SyncAccess::class,
        Commands\NakoaV1SyncProcure::class,
        Commands\NakoaV1SyncWarehouse::class,
        Commands\NakoaV1SyncSale::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('nakoa:sync:access')->dailyAt('18:10');
        $schedule->command('nakoa:sync:procure')->dailyAt('18:20');
        $schedule->command('nakoa:sync:warehouse')->dailyAt('18:55');
        $schedule->command('nakoa:sync:sale')->dailyAt('20:10');
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
