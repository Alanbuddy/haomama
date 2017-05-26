@extends('layout.app')
@section('content')
    <div class="row">
        <div id="id_video_container_9031868222917328248" style="width:100%;height:0px;"></div>
        <script src="https://qzonestyle.gtimg.cn/open/qcloud/video/h5/h5connect.js" charset="utf-8"></script>
        <script type="text/javascript">
            (function () {
                var option = {
                    "auto_play": "1",
                    "file_id": "9031868222922882965",
                    "app_id": "1252044713",
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
@endsection
