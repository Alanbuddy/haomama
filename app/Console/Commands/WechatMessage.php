<?php

namespace App\Console\Commands;

use App\Jobs\SendWechatMessage;
use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WechatMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wx:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send wechat notification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->sendBefore24h();
        $this->sendBefore32h();
    }

    //线下课程开课前24小时，发送微信消息给课程学员
    public function sendBefore24h()
    {
        Log::info('----------------------------send wechat notification before 24h----------------------------');
        $date = date('Y-m-d H', strtotime('+24 hour'));
        $courses = $this->dueCourses($date, 'students');
        foreach ($courses as $course) {
            foreach ($course->students as $user) {
                $job = (new SendWechatMessage($user, $course))->onQueue('wechat');
                dispatch($job);
            }
        }

    }

    //线下课程开课前３２小时，给收藏过课程的用户发送微信消息
    public function sendBefore32h()
    {
        $date = date('Y-m-d H', strtotime('+32 hour'));
        $courses = $this->dueCourses($date, 'followers');
        foreach ($courses as $course) {
            foreach ($course->followers as $user) {
                $job = (new SendWechatMessage($user, $course, false))->onQueue('wechat');
                dispatch($job);
            }
        }
    }

    /**
     * @param $date
     * @return mixed
     */
    public function dueCourses($date, $relation)
    {
        $courses = Course::where('type', 'offline')
            ->where(DB::raw('date_format(begin,"%Y-%m-%d %H")'), $date)
            ->with($relation)
            ->get();
        return $courses;
    }

}
