@extends('layout.app')

@section('ccc')
    <div class="row">
        <a id="wechat">wechat login</a>
        <a id="wechatbase">wechat base</a>
        <div id="id_video_container_9031868222917328248" style="width:100%;height:0px;"></div>
        <script src="https://qzonestyle.gtimg.cn/open/qcloud/video/h5/h5connect.js" charset="utf-8"></script>
        <script type="text/javascript">
            (function () {
                var option = {
                    "auto_play": "1",
                    "file_id": "9031868222953457775",
                    "app_id": "1253793695",
                    "width": 640,
                    "height": 480,
                    "https": 1
                };
                /*调用播放器进行播放*/
                player = new qcVideo.Player(/*代码中的id_video_container将会作为播放器放置的容器使用,可自行替换*/ "id_video_container_9031868222917328248", option);

                var barrage = [
                    {"type": "content", "content": "hello world", "time": "1"},
                    {"type": "content", "content": "居中显示", "time": "1", "style": "C64B03;30", "position": "center"}
                ];

                window.setTimeout(function () {
                    player.addBarrage(barrage);
                    console.log(2);
                }, 1000);

            })()
        </script>
    </div>
    {{--JS-SDK--}}
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        wx.config({
            debug: true,
            appId: '{{ $signPackage["appId"]}}',
            timestamp: '{{ $signPackage["timestamp"]}}',
            nonceStr: '{{ $signPackage["nonceStr"]}}',
            signature: '{{ $signPackage["signature"]}}',
            jsApiList: [
                // 所有要调用的 API 都要加到这个列表中
                'onMenuShareTimeline'
            ]
        });
        wx.ready(function () {
            // 在这里调用 API
            wx.onMenuShareTimeline({
                title: '', // 分享标题
                link: '', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: '', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                    alert('shared');
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
        });
    </script>
    <script>
        var appId = "{{config('wechat.mp.app_id')}}";
        var node = document.getElementById('wechat');
        var app_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid="
            + appId
            + "&redirect_uri=http%3a%2f%2f"
            + "baby.fumubidu.com.cn/haomama/wechat/login&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect";
//        node.setAttribute('href', pc_url);
//        $.ajax('/' + navigator.userAgent);
        if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|SymbianOS)/i))) {
            if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) == 'micromessenger') {
                node.setAttribute('href', app_url);
            }
        }

        var snsapi_base_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid="
            + appId
            + "&redirect_uri=http%3a%2f%2f"
            + "baby.fumubidu.com.cn/haomama/wechat/openid&response_type=code&scope=snsapi_base&state=STATE&connect_redirect=1#wechat_redirect";
        var node = document.getElementById('wechatbase');
        node.setAttribute('href', snsapi_base_url );
    </script>
@endsection

