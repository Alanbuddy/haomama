<?php

namespace App\Console\Commands;

use App\Jobs\SendWechatMessage;
use App\Models\Course;
use Illuminate\Console\Command;
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
        Log::info('----------------------------executed----------------------------');
        $courses = Course::where('type', 'offline')
            ->where('id', '>', 0)
            ->with('users')
            ->get();
        foreach ($courses as $course) {
            foreach ($course->users as $user) {
                Log::info($user->id);
                $job = (new SendWechatMessage(auth()->user(), Course::first()))->onQueue('wechat');
                dispatch($job);
            }
        }
    }

}