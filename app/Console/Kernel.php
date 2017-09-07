<?php

namespace App\Console;

use App\Console\Commands\AutoRefundWhenNotMeetRequirement;
use App\Console\Commands\changeCredential;
use App\Console\Commands\enroll;
use App\Console\Commands\refund;
use App\Console\Commands\Stat;
use App\Console\Commands\test;
use App\Console\Commands\WechatMessage;
use App\Console\Commands\Ws;
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
        refund::class,
        WechatMessage::class,
        enroll::class,
        Ws::class,
        changeCredential::class,
        Stat::class,
        AutoRefundWhenNotMeetRequirement::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //课前提醒
        $schedule->command('wx:send')->hourly();
        //线下课程开课前24小时,人数不够则自动退款
        $schedule->command('schedule:refund')->hourly();
        //每天午夜统计用户相关数据
        $schedule->command('stat:user')->daily();
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
