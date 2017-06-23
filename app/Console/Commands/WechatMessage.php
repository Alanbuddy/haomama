<?php

namespace App\Console\Commands;

use App\Http\Wechat\WxApi;
use App\Http\Wechat\WxMessageApi;
use App\Models\Course;
use App\Models\Error;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class WechatMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechatMessage:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
                $this->sendMessage($user);
            }
        }

    }

    public function sendMessage(User $user,
                                $template_id = "YOjEUmaFcJ-27cx82zG6UVz9D23Mvbtv_5NDjhKT-Lw",
                                $url = 'http://www.baidu.com')
    {
        $result = WxApi::accessToken();
        if ($result['success']) {
            $access_token = $result['data']->access_token;
            $template_id = $template_id;
            $url = $url;
            $data = [
                "first" => [
                    "value" => "恭喜你购买成功！",
                    "color" => "#173177"
                ],
                "keyword1" => [
                    "value" => "上课时间",
                    "color" => "#173177"
                ],
                "keyword2" => [
                    "value" => "课程类型",
                    "color" => "#173177"
                ],
                "keyword3" => [
                    "value" => "教师姓名",
                    "color" => "#173177"
                ],
                "remark" => [
                    "value" => "欢迎再次购买！",
                    "color" => "#173177"
                ]
            ];
            $result = WxMessageApi::send($access_token, $user->openid, $template_id, $url, $data);

//        dd($result);
            if (json_decode($result['data'])->errcode > 0) {
                Error::create([
                    'user_id' => 1,
                    'type' => 'wx.send',
                    'message' => 'send message failed',
                    'data' => $result,
                    'context' => json_encode(compact('access_token', 'template_id', 'url'))
                ]);
            }
        } else {
            Error::create([
                'type' => 'wx.access_token',
                'message' => 'access_token',
                'data' => $result,
            ]);
        }
    }
}
