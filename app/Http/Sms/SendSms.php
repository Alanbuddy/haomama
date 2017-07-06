<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-7-6
 * Time: 下午5:22
 */

namespace app\Http\Sms;


use App\Http\Util\Curl;

trait SendSms
{
    /**
     * @param $phones //接收号码，多个用逗号隔开，非空。
     * @param $content //短信内容，非空。长度不能超过500字符，超出返回失败信息。
     * @return array   //返回值示例  array:2 [ "code" => 200, "data" => "1|1707061719486692|操作成功" ]
     * array:2 [ "code" => 200 "data" => "3077||超出每天最大发送条数" ]
     */
    public static function sendSms($phones = ['18911209450'], $content)
    {
        $api_url = config('services.sms.url');

        $Msisdn = implode(',', $phones);//接收号码，多个用逗号隔开，非空。
        $SMSContent = $content;//短信内容，非空。长度不能超过500字符，超出返回失败信息。
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
        $response = Curl::request($url);
        $arr = explode('|', $response['data']);
        if ($response['code'] == 200 && $arr[0] == 1) {
            return ['success' => true, 'data' => $response['data']];
        }
        return ['success' => false, 'message' => $arr];
    }
}