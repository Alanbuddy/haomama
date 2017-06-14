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
    use Curl;

    public static function send(Request $request)
    {
        $api_url = config('services.sms.url');

        $Msisdn = '18911209450';
        $SMSContent = 'haha你好吗';
        $MSGType = 1;
        $ECECCID = config('services.sms.account');
        $Password = config('services.sms.password');
        $queryData = compact(
            'MSGType',
            'Msisdn',
            'SMSContent',
            'ECECCID',
            'Password'
        );
        $url = $api_url . '?' . http_build_query($queryData);
        return Curl::request($url);
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
}
