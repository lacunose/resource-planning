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
        $schedule->command(Command\NakoaV1SyncAccess::class)->dailyAt('22:00');
        $schedule->command(Command\NakoaV1SyncProcure::class)->dailyAt('22:30');
        $schedule->command(Command\NakoaV1SyncWarehouse::class)->dailyAt('23:00');
        $schedule->command(Command\NakoaV1SyncSale::class)->dailyAt('23:30');
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
