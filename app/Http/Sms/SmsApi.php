<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-25
 * Time: 上午11:19
 */

namespace App\Http\Sms;

use App\Http\Util\Curl;
use Illuminate\Http\Request;

class SmsApi
{
    use Curl, SendSms;

    /**
     * 返回值示例  array:2 [ "code" => 200, "data" => "1|1707061719486692|操作成功" ]
     * @param Request $request
     * @return array
     */

    public static function send(Request $request)
    {
        session(['phone' => $request->mobile]);
        $code = rand(100000, 999999);
        session(['code'=>$code]);
//        session(['code' => 111111]);

        $content = '验证码:' . $code.' 【好妈妈微课】';
//        return static::sendSms(['18911209450'], $content);
        return static::sendSms([$request->mobile], $content);
    }

    //查询余量
    //每次查询时间间隔需要大于30秒，否则返回失败状态。
    //返回结果：
    //Result：提交状态  (1：成功 ； -1：失败 其它参考 差错定义)
    //SMS：短信余量
    //MMS：彩信余量
    public static function residual()
    {

        $api_url = 'http://pi.noc.cn/QueryAmount.aspx';//接口地址
        $ECECCID = config('services.sms.account');
        $Password = config('services.sms.password');
        $queryData = compact(
            'ECECCID',
            'Password'
        );
        $url = $api_url . '?' . http_build_query($queryData);
        return Curl::request($url);

    }

    public static function verify(Request $request)
    {
        if ($request->has('code') && $request->has('phone')) {
            $result = ($request->code == session('code')) &&
                ($request->phone == session('phone'));
            return ['success' => $result];
        }
        return ['success' => false];
    }
}
