var payUrl = '/haomama/orders/pay';

var signPackage;
alert('pay.js');
function pay() {
    $.ajax({
        url: payUrl,
        type: 'post',
        data: {
            course_id: 23,
            _token: token,
        },
        success: function (resp) {
            console.log(resp);
            alert(JSON.stringify(resp));
            signPackage = resp.data;
            jsBrage();
        }
    });
    alert('after ajax request');
}
function jsBrage() {
    if (typeof WeixinJSBridge == 'undefined') {
        if (document.addEventListener) {
            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        } else if (document.attachEvent) {
            document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
        }
    } else {
        onBridgeReady();
    }
}
function onBridgeReady() {
    alert('signPackage.timeStamp='+signPackage.timeStamp);
    WeixinJSBridge.invoke('getBrandWCPayRequest', {
        'appId': ''+signPackage.appId,
        'timeStamp': ''+signPackage.timeStamp,
        'nonceStr': ''+signPackage.nonceStr,
        'package': ''+signPackage.package,
        'signType': 'MD5', //微信签名方式：
        'paySign': ''+signPackage.sign,
    }, function (res) {
        if (res.err_msg == 'get_brand_wcpay_request:ok') {
            alert(res);
            checkPayment();
            alert(3);
        } // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。

    });
}

function checkPayment() {
    alert('call checkPayment');
    $.ajax({
        type: 'post',
        url: '{{route(\'orders.payment.update\',$order->uuid)}}',
        data: {
            _token: '{{csrf_token()}}'
        },
        success: function (response) {
            alert('success');
        },
        error: function (response) {
            alert(response);
        }
    });
}