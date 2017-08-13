<?php

namespace App\Jobs;

use App\Facades\MessageFacade;
use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWechatMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $course;
    //recipient
    protected $user;

    protected $hasEnrolled;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Course $course, $hasEnrolled = true)
    {
        //
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
        MessageFacade::sendWechatPreClassMessage($this->user, $this->course,$this->hasEnrolled);
//        try {
//        MessageFacade::sendBuyCompletedMessage($this->user, $this->course);
//        } catch (WxException $e) {
//            Error::create([
//                'user_id' => 1,
//                'type' => 'queue.wx.send',
//                'message' => 'send message failed',
//                'data' => $e->getMessage(),
//                'context' => '',
//            ]);
//        }
    }
}
