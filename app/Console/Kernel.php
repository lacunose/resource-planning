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
<<<<<<< HEAD
        Commands\CreateWebsite::class,
=======
        //
        Commands\NakoaV1SyncAccess::class,
        Commands\NakoaV1SyncSale::class,
>>>>>>> 8a4e788cd197070a929f1f35c583e4b73a664406
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
<<<<<<< HEAD
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
=======
    protected function schedule(Schedule $schedule) {
        // $schedule->command('nakoa:sync:access')->dailyAt('06:00');
        // $schedule->command('nakoa:sync:sale')->everyFifteenMinutes();
>>>>>>> 8a4e788cd197070a929f1f35c583e4b73a664406
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
