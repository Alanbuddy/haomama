<?php

namespace App\Console;

use App\Console\Commands\changeCredential;
use App\Console\Commands\enroll;
use App\Console\Commands\Stat;
use App\Console\Commands\test;
use App\Console\Commands\WechatMessage;
use App\Console\Commands\Ws;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use MtHaml\Exception;

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
        WechatMessage::class,
        enroll::class,
        Ws::class,
        changeCredential::class,
        Stat::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire') ->hourly();

//        $schedule->command('wx:send')->everyTenMinutes();
        $schedule->command('wx:send')->hourly();
//        $schedule->call(function () {
//            print("every 5 minute\n");
//            DB::table('recent_users')->delete();
//        })->everyMinute();

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
