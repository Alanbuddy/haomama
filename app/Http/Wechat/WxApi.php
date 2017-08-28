<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-23
 * Time: 下午5:10
 */

namespace App\Http\Wechat;

use App\Http\Util\Curl;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

/**
 *
 * 接口访问类，包含微信API列表的封装，类中方法为static方法，
 * 每个接口有默认超时时间（除提交被扫支付为10s，上报超时时间为1s外，其他均为6s）
 * @author widyhu
 *
 */
class WxApi
{
    use Curl;

    //微信网页授权是通过OAuth2.0机制实现的，在用户授权给公众号后，公众号可以获取到一个网页授权特有的接口调用凭证（网页授权access_token），
    //通过网页授权access_token可以进行授权后接口调用，如获取用户基本信息；
    /*** 获取网页授权 access_token */
    public static function oauthAccessToken($code)
    {
        $appid = config('wechat.mp.app_id');
        $secret = config('wechat.mp.app_secret');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token"
            . "?appid=" . $appid
            . "&secret=" . $secret
            . "&code=" . $code
            . "&grant_type=authorization_code";
        $response = self::request($url);
        return $response;
    }

    /**
     * 获取普通access_token
     * @param bool $forceRefresh
     * @return array
     */
    public static function accessToken($forceRefresh = false)
    {
        $accessToken = Setting::where('key', 'access_token')->first();
        $data = json_decode($accessToken->value);
//        dd(time().' '.$data->expire_time);
        if ($data->expire_time < time() || $forceRefresh) {
            Log::info("access token expired  !!!");
            $url = "https://api.weixin.qq.com/cgi-bin/token";
            $queryData = [
                'grant_type' => 'client_credential',
                'appid' => config('wechat.mp.app_id'),//公众账号ID
                'secret' => config('wechat.mp.app_secret'),//应用密钥
            ];
            $url .= "?" . http_build_query($queryData);
            $response = self::request($url);
            if ($response['code'] == 200) {
                $access_token = json_decode($response['data'])->access_token;

                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $accessToken->value = json_encode($data);
                $accessToken->update();
            } else {
                return ['success' => false, 'message' => 'curl error:' . $response];
            }
        }
        return ['success' => true, 'data' => $data];
    }

    // call userinfo inteface
    public static function userInfo($access_token, $openid)
    {
        $url = "https://api.weixin.qq.com/sns/userinfo"
            . "?access_token=" . $access_token
            . "&openid=" . $openid;
        $response = self::request($url);
        return $response;
    }

    //获取用户基本信息（包括UnionID机制）
    //https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140839
    public static function commonUserInfo($openId)
    {
        $result = WxApi::accessToken();
        if ($result['success']) {
            $accessToken = $result['data']->access_token;
            $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $accessToken . '&openid=' . $openId . '&lang=zh_CN';
            $response = self::request($url);
            return $response;
        }else{
            return false;
        }
    }

    //获取帐号的关注者列表
    //https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140840
    public static function subscribers($nextOpenid = null)
    {
        $result = WxApi::accessToken();
        if ($result['success']) {
            $accessToken = $result['data']->access_token;
            $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='
                . $accessToken
                . ($nextOpenid ? '&next_openid=' . $nextOpenid : '');
            $response = self::request($url);
            return $response;
        } else {
            return false;
        }
    }

    /**
     * copy from app/Http/Wechat/sdk/lib/WxPay.Api.php:435
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    public static function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 生成签名
     * @return 签名
     */
    public static function makeSign($values)
    {
        //签名步骤一：按字典序排序参数
        ksort($values);
        $string = self::toUrlParams($values);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . config('wechat.mch.key');
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /**
     * copy from \App\Http\Wechat\sdk\lib\WxPayDataBase::ToUrlParams
     * 格式化参数格式化成url参数
     */
    public static function toUrlParams($values)
    {
        $buff = "";
        foreach ($values as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

}

/**
 * 微信API异常类
 */
class WechatException extends \Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }
}
