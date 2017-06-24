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
    public function sendWechatMessage(User $user,
                                      $template_id = "YOjEUmaFcJ-27cx82zG6UVz9D23Mvbtv_5NDjhKT-Lw",
                                      $url = 'http://www.baidu.com',
                                      $data = null)
    {
        $result = WxApi::accessToken();
        if ($result['success']) {
            $access_token = $result['data']->access_token;
            $data = $data ?: [
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