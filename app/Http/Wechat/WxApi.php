<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-23
 * Time: 下午5:10
 */

namespace App\Http\Wechat;

use App\Http\Util\Curl;

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

    /**
     * 获取access token
     */
    public static function accessToken($timeOut = 6)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token";
        $queryData = [
            'grant_type' => 'client_credential',
            'appid' => config('wechat.mp.app_id'),//公众账号ID
            'secret' => config('wechat.mp.app_secret'),//应用密钥
        ];
        $url .= "?" . http_build_query($queryData);
//        var_dump($url);
        $response = self::request($url);
        $result = $response;
        return $result;
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
