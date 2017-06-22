<?php

namespace App\Console;

use App\Console\Commands\test;
use App\Console\Commands\WechatMessage;
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
        print("success\n");
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            print("every 5 minute\n");
//            DB::table('recent_users')->delete();
        })->everyMinute();

        var_dump($_SERVER);
//        $schedule->command('wechatMessage:send');
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
