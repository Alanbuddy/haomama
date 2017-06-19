<?php

namespace App\Console;

use App\Console\Commands\test;
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
        test::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        file_put_contents('/home/gao/run.log', date('Y-m-d H:i:s')."\r\n", FILE_APPEND);
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
//            DB::table('recent_users')->delete();
        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
