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

    public static function residual()
    {
        $api_url = 'http://pi.noc.cn/QueryAmount.aspx';
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
