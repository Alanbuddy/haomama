@extends('layout.app')

@section('title')
    Lesson index
@endsection

@section('content')
    <h2>pay test</h2>
@endsection

@section('script')
    <script>
//        checkPayment();
        function onBridgeReady() {
//            var timeStamp = Math.round((new Date().getTime()) / 1000);
//            alert(timeStamp);
//            alert(typeof jQuery);
            {{--alert("{{route('orders.payment.update',$order)}}");--}}
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest', {
                    "appId": "{{$appId}}",     //公众号名称，由商户传入
                    "timeStamp": "{{$timeStamp}}",         //时间戳，自1970年以来的秒数
                    "nonceStr": "{{$nonceStr}}", //随机串
                    "package": "prepay_id={{$prepayId}}",
                    "signType": "MD5",         //微信签名方式：
                    "paySign": "{{$sign}}" //微信签名
                },
                function (res) {
                    if (res.err_msg == "get_brand_wcpay_request:ok") {
                        alert("{{route('orders.payment.update',$order->uuid)}}");
                        checkPayment();
                        alert(3);
                    }     // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
                }
            );
        }
        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        } else {
            onBridgeReady();
        }

        function checkPayment() {
            alert('call checkPayment');
            $.ajax({
                type: 'post',
                url: "{{route('orders.payment.update',$order->uuid)}}",
                data:{
                    _token:"{{csrf_token()}}"
                },
                success: function (response) {
                    alert('success');
                },
                error: function (response) {
                    alert(response);
                }
            });
        }
    </script>
@endsection
