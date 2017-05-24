<?php

namespace App\Http\Controllers;

require_once __DIR__."/../Wechat/WxApi.php";

use App\Http\Util\Curl;
use App\Http\Wechat\WxApi;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WechatController extends Controller
{
    use Curl;

    public function accessToken(Request $request)
    {
        $result = WxApi::accessToken();
        dd($result);
    }

    public function loginViaApp(Request $request)
    {
        $appid = "wx75f10d3752bb2616";
        $secret = "0a952956f084e83c92ebf87c0d8eca73";
        $code = $request->get('code');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token"
            . "?appid=" . $appid
            . "&secret=" . $secret
            . "&code=" . $code
            . "&grant_type=authorization_code";
        //get access_token
        $response = $this->request($url);
        if ($response["code"] == 200) {
            $wechatResponse = json_decode($response["data"]);
            // call userinfo inteface
            $url = "https://api.weixin.qq.com/sns/userinfo"
                . "?access_token=" . $wechatResponse->access_token
                . "&openid=" . $wechatResponse->openid;
            $response = $this->getResult($url);
            if ($response["code"] == 200) {
                //Login
                $data = json_decode($response["data"]);
                $user = User::where('unionid', $data->unionid)->first();
                if (!$user) {
                    //return $data->unionid.'<br> '.$data->openid;
                    //ottv0v7t-gLxhQm80J1FXNXNQJcI //unionid
                    //o6NOov97zOl_1f3pFcG_rg-5SpIM //openid

                    $url = 'http://ucenter.lingosail.com/auth/register';
                    $field['name'] = $data->unionid;
                    $field['password'] = $data->openid;
                    $field['email'] = $data->openid . "@app.com";
                    $backInfo = $this->getResult($url, $field, $timeout = 1000, $method = "post");
                    if ($backInfo['code'] == 200) {
                        $info = json_decode($backInfo['data'], true);
                        if ($info['status'] == 1) {
                            $userInfo = $info['data'];
                            $user = new User();
                            $user->id = $userInfo['id'];
                            $user->name = $data->unionid;
                            $user->openid = $data->openid;
                            $user->oauth = 'wechat';
                            $user->save();
                        } else {
                            return 'error';
                        }
                    }
                }
                Auth::loginUsingId($user->id);
                return redirect('/');
            }
        }
        return 'ERROR:' . $response["code"];
    }

    public function paymentNotify()
    {
    }
}
