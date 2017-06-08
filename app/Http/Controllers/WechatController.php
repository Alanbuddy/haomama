<?php

namespace App\Http\Controllers;

require_once __DIR__ . "/../Wechat/WxApi.php";

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

    public function login(Request $request)
    {
        $appid = config('wechat.mp.app_id');
        $secret = config('wechat.mp.app_secret');
        $code = $request->get('code');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token"
            . "?appid=" . $appid
            . "&secret=" . $secret
            . "&code=" . $code
            . "&grant_type=authorization_code";
        //get access_token
        $response = $this->request($url);
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
                    $user->password = '123';
                    $user->save();
                }
                //Login
                Auth::loginUsingId($user->id);
                return redirect('/haomama');
            }
        }
        return 'ERROR:' . $response["code"];
    }

    public function paymentNotify()
    {
    }
}
