<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-15
 * Time: 上午9:34
 */

namespace App\Services;


use App\Http\Wechat\WxApi;
use App\Http\Wechat\WxException;
use App\Http\Wechat\WxMessageApi;
use App\Models\Course;
use App\Models\Error;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class MessageService
{
    /**
     * @param $attributes
     * @param $to User Id
     */
    public function send($attributes, $to)
    {
        $message = new Message();
//        if ($attributes['object_type'] == 'comment') {
        $existingMessage = Message::where('object_id', $attributes['object_id'])
            ->where('to', $to)
            ->first();
        $message = $existingMessage ?: $message;
//        } else if ($attributes['object_type'] == 'course') {
//            $existingMessage = Message::where('object_id', $attributes['object_id'])->first();
//            $message = $existingMessage ?: $message;
//        }
        $message->fill($attributes);
        if ($existingMessage) {
            //消息列表按created_at排序，所以要更新created_at字段使这条消息重新排到前面
            $message->created_at = date('Y-m-d H:i:s');
            $message->update();
        } else {
            $message->save();
        }
    }

    //线下课程开课前24小时发送微信模板消息
    public function sendWechatPreClassMessage(User $user, Course $course)
    {
        Log::info(__FILE__ . 'sendWechatPreClassMessage');
        $template_id = "YOjEUmaFcJ-27cx82zG6UVz9D23Mvbtv_5NDjhKT-Lw";
        $url = env('APP_URL') . route('courses.show', $course);
        $result = WxApi::accessToken();
        if ($result['success']) {
            $access_token = $result['data']->access_token;
            $data = [
                "first" => [
                    "value" => '课程' . $course->name . "快要上课了！",
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
                    "value" => "预祝学习愉快！",
                    "color" => "#173177"
                ]
            ];
            $result = WxMessageApi::send($access_token, $user->openid, $template_id, $url, $data);

//        dd($result);
            if (json_decode($result['data'])->errcode > 0) {
                Log::error('error :' . $result['data']);
                Error::create([
                    'user_id' => 1,
                    'type' => 'wx.send',
                    'message' => 'send message failed',
                    'data' => json_encode($result),
                    'context' => json_encode(compact('access_token', 'template_id', 'url'))
                ]);
                throw new WxException(json_decode($result['data'])->errmsg);
            }
        } else {
            Error::create([
                'type' => 'wx.access_token',
                'message' => 'access_token',
                'data' => $result['message'],
            ]);
        }
    }

    public function sendBuyCompletedMessage(User $user, Course $course)
    {
        $template_id = '5NwLAPuRyj7VFpC0_ym14STqFsFfFyxC20lqezi_GO4';
        $url = env('APP_URL') . route('courses.show', $course);
        $result = WxApi::accessToken();
        if ($result['success']) {
            $access_token = $result['data']->access_token;
            $data = [
                "name" => [
                    "value" => '课程:' . $course->name . "",
                    "color" => "#f21212"
                ],
                "remark" => [
                    "value" => "预祝学习愉快！",
                ]
            ];
            $result = WxMessageApi::send($access_token, $user->openid, $template_id, $url, $data);
//        dd($result);
            if (json_decode($result['data'])->errcode > 0) {
                Error::create([
                    'user_id' => 1,
                    'type' => 'wx.send',
                    'message' => 'send message failed',
                    'data' => json_encode($result),
                    'context' => json_encode(compact('access_token', 'template_id', 'url'))
                ]);
                throw new WxException(json_decode($result['data'])->errmsg);
            }
        } else {
            Error::create([
                'type' => 'wx.access_token',
                'message' => 'access_token',
                'data' => $result['message'],
            ]);
        }
    }

//模板IDEfzvbLUYiyAfzgFFEdWV-tXBzHxkICXiMUim75-UU4k
//开发者调用模板消息接口时需提供模板ID
//标题退款通知
//行业IT科技 - 互联网|电子商务
//详细内容
//{{first.DATA}}
//
//退款原因：{{reason.DATA}}
//退款金额：{{refund.DATA}}
//{{remark.DATA}}
//在发送时，需要将内容中的参数（{{.DATA}}内为参数）赋值替换为需要的信息
//内容示例
//您好，您对微信影城影票的抢购未成功，已退款。
//退款原因：未抢购成功
//退款金额：70元
//备注：如有疑问，请致电13912345678联系我们，或回复M来了解详情。
    public function sendRefundCompletedMessage(User $user, Course $course)
    {
        $template_id = 'EfzvbLUYiyAfzgFFEdWV-tXBzHxkICXiMUim75-UU4k';
        $url = env('APP_URL') . route('courses.show', $course);
        $result = WxApi::accessToken();
        if ($result['success']) {
            $access_token = $result['data']->access_token;
            $data = [
                "reason" => [
                    "value" => '课程:' . $course->name . "已退款",
                    "color" => "#f21212"
                ],
                "refund" => [
                    "value" => '￥'.($course->price?:$course->original_price),
                    "color" => "#f21212"
                ],
                "remark" => [
                    "value" => "",
                ]
            ];
            $result = WxMessageApi::send($access_token, $user->openid, $template_id, $url, $data);
//        dd($result);
            if (json_decode($result['data'])->errcode > 0) {
                Error::create([
                    'user_id' => 1,
                    'type' => 'wx.send',
                    'message' => 'send message failed',
                    'data' => json_encode($result),
                    'context' => json_encode(compact('access_token', 'template_id', 'url'))
                ]);
                throw new WxException(json_decode($result['data'])->errmsg);
            }
        } else {
            Error::create([
                'type' => 'wx.access_token',
                'message' => 'access_token',
                'data' => $result['message'],
            ]);
        }
    }

    public function sendCourseUpdateReminder(User $user, Course $course)
    {
        $template_id = 'mn7iRfoNxcYRhzA3mPBLQw0ynAWyjluZVvqir2H9uKo';
        $url = env('APP_URL') . route('courses.show', $course);
        $result = WxApi::accessToken();
        if ($result['success']) {
            $access_token = $result['data']->access_token;
            $data = [
                "first" => [
                    "value" => '课程' . $course->name . "已更新！快来学习吧",
                    "color" => "#f21212"
                ],
                "keyword1" => [
                    "value" => $course->name,
                    "color" => "#173177"
                ],
                "keyword2" => [
                    "value" => '已更新',
                    "color" => "#173177"
                ],
                "keyword3" => [
                    "value" => "上课中",
                    "color" => "#173177"
                ],
                "remark" => [
                    "value" => "预祝学习愉快！",
                    "color" => "#173177"
                ]
            ];
            $result = WxMessageApi::send($access_token, $user->openid, $template_id, $url, $data);
//        dd($result);
            var_dump($result);
            if (json_decode($result['data'])->errcode > 0) {
                Error::create([
                    'user_id' => 1,
                    'type' => 'wx.send',
                    'message' => 'send message failed',
                    'data' => json_encode($result),
                    'context' => json_encode(compact('access_token', 'template_id', 'url'))
                ]);
                throw new WxException(json_decode($result['data'])->errmsg);
            }
        } else {
            Error::create([
                'type' => 'wx.access_token',
                'message' => 'access_token',
                'data' => $result['message'],
            ]);
        }
    }
}