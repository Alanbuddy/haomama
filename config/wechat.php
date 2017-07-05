<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-23
 * Time: 上午8:59
 */
return [

    'mp' => [
        'app_id' => env('MP_APP_ID'),//公众账号ID
        'app_secret' => env('MP_APP_SECRET')//应用密钥
    ],

    'mch' => [
        'mch_id' => env('MCH_ID'),//微信支付分配的商户号
        'key' => env('MCH_KEY'),//密钥设置
        'prepay_url' => 'http://baby.fumubidu.com.cn/haomama/wechat/payment/prepay',//返回预付单URL
        'notify_url' => 'http://baby.fumubidu.com.cn/haomama/wechat/payment/notify',//通知商户支付结果URL,
    ]
];
