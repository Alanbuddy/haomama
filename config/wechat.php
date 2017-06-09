<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-23
 * Time: 上午8:59
 */
return [

    'mp' => [
        'app_id' => 'wx981a082d6be5368f',//公众账号ID
        'app_secret' => 'b67893df5065b1417f0d2fc1ff3eca75'//AppSecret(应用密钥)
    ],

    'mch' => [
        'mch_id' => '1219720601',//微信支付分配的商户号
        'key' => '1980FUMU0401bidu1999AMAO001gushi',//密钥设置
        'prepay_url' => 'http://baby.fumubidu.com.cn/haomama/wechat/payment/prepay',//返回预付单URL
        'notify_url' => 'http://baby.fumubidu.com.cn/haomama/wechat/payment/notify',//通知商户支付结果URL,
        'unified_order_url' => 'https://api.mch.weixin.qq.com/pay/unifiedorder',//>统一下单接口链接
    ]
];
