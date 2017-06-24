<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-15
 * Time: 上午9:34
 */

namespace App\Services;


use App\Http\Wechat\WxApi;
use App\Http\Wechat\WxMessageApi;
use App\Models\Course;
use App\Models\Error;
use App\Models\Message;
use App\Models\User;

class MessageService
{
    public function send($attributes)
    {
        $message = new Message();
        if ($attributes['object_type'] == 'comment') {
            $existingMessage = Message::where('object_id', $attributes['object_id'])->first();
            $message = $existingMessage ?: $message;
        } else if ($attributes['object_type'] == 'course') {
            $existingMessage = Message::where('object_id', $attributes['object_id'])->first();
            $message = $existingMessage ?: $message;
        }
        $message->fill($attributes);
        if ($existingMessage) {
            //消息列表按created_at排序，所以要更新created_at字段使这条消息重新排到前面
            $message->created_at = date('Y-m-d H:i:s');
            $message->update();
        } else {
            $message->save();
        }
    }

    //发送微信模板消息
    public function sendWechatPreClassMessage(User $user,Course $course)
    {
        $template_id = "YOjEUmaFcJ-27cx82zG6UVz9D23Mvbtv_5NDjhKT-Lw";
        $url = route('courses.show',$course);
        $result = WxApi::accessToken();
        if ($result['success']) {
            $access_token = $result['data']->access_token;
            $data = [
                "first" => [
                    "value" => "恭喜你购买成功！",
                    "color" => "#f21212"
                ],
                "keyword1" => [
                    "value" => $course->begin,
                    "color" => "#173177"
                ],
                "keyword2" => [
                    "value" => '线下',
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