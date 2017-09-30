<?php

namespace App\Jobs;

use App\Http\Sms\SmsApi;
use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $course;
    //recipient
    protected $user;

    protected $hasEnrolled;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Course $course
     * @param bool $hasEnrolled
     */
    public function __construct(User $user, Course $course, $hasEnrolled = true)
    {
        $this->user = $user;
        $this->course = $course;
        $this->hasEnrolled = $hasEnrolled;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $phone = $this->user->phone;
        Log::info(__METHOD__ . $phone);
        Log::info(__METHOD__ . '提醒SMS');
        if ($phone) {
            $content = '【好妈妈微课】课程'
                . $this->course->name
                . "快开课了！"
                . ($this->hasEnrolled ? "预祝学习愉快！" : "欢迎报名!");
            SmsApi::sendSms([$phone], $content);
        }
    }
}
