<?php

namespace App\Http\Controllers;

require_once __DIR__ . "/../Wechat/WxApi.php";

use App\Http\Util\Curl;
use App\Http\Wechat\WxApi;
use App\Http\Wechat\WxMessageApi;
use App\Models\Error;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WechatController extends Controller
{
    use Curl;

    public function accessToken(Request $request)
    {
        $result = WxApi::accessToken();
        dd($result);
    }

    // 获得模板ID
    public function getTemplateID(Request $request)
    {
        $result = WxApi::accessToken();
        if ($result['success']) {
            $access_token = $result['data']->access_token;
            $result = WxMessageApi::getTemplateId($access_token);
        }
        dd($result);
    }

    // 获得所有模板
    public function getTemplate(Request $request)
    {
        $result = WxApi::accessToken();
        if ($result['success']) {
            $access_token = $result['data']->access_token;
            $result = WxMessageApi::getTemplate($access_token);
        }
        dd($result);
    }

    public function getIndustry(Request $request)
    {
        $result = WxApi::accessToken();
        if ($result['success']) {
            $access_token = $result['data']->access_token;
            $result = WxMessageApi::getIndustry($access_token);
        }
        dd($result);
    }

    public function login(Request $request)
    {
        $code = $request->get('code');
        $response = WxApi::oauthAccessToken($code);
        if ($response["code"] == 200) {
            $data = json_decode($response["data"]);
            $response = WxApi::userInfo($data->access_token, $data->openid);
            if ($response["code"] == 200) {
                $data = json_decode($response["data"]);
                $user = User::where('openid', $data->openid)->first();
                if (!$user) {
                    $user = new User();
                    $user->name = $data->nickname;
                    $user->openid = $data->openid;
                    $user->avatar = $data->headimgurl;
                    $user->password = '123';
                    $user->wx = $response["data"];
                    $user->save();
                }
                //Login
                Auth::loginUsingId($user->id);
                return redirect('/');
            }
        }
        return 'ERROR:' . $response["code"];
    }

    public function openid(Request $request)
    {
        $result = WxApi::oauthAccessToken($request->code);
        dd($result);
    }

    public function send()
    {
        $result = WxApi::accessToken();
        if ($result['success']) {
            $access_token = $result['data']->access_token;
            $template_id = "YOjEUmaFcJ-27cx82zG6UVz9D23Mvbtv_5NDjhKT-Lw";
            $url = 'http://baidu.com';
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
            $result = WxMessageApi::send($access_token, null, $template_id, $url, $data);
        }

//        dd($result);
        if (json_decode($result['data'])->errcode > 0) {
            Error::create([
                'user_id' => auth()->user()->id,
                'type' => 'wx.send',
                'message' => 'send message failed',
                'data' => json_encode($result),
                'context' => json_encode(compact('access_token', 'template_id', 'url'))
            ]);
        }
        return $result;
    }

}
