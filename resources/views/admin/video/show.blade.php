@extends('layout.app')
@section('css')
    <style>
        .barrage {
            /*position: relative;*/
            position: absolute;
            top: 50%;
            left: 100%;
            height: 50px;
            color: beige;
            font-weight: bold;
            display: inline-block;
            font-size: 2rem;
            white-space:nowrap;
        }
    </style>
@endsection
@section('content')
    @include('common.message')
    @include('admin.video.menu')

    {{--视频播放--}}
    @if($item->video_type=='common')
        <div class="row">
            <div id="id_video_container_9031868222917328248" style="width:100%;height:0px;"></div>
        </div>
    @else
        @foreach($item->attachments as $i)
            <img src="{{$i->path}}" style="width:400px ;height: 300px;" title="{{$i->file_name}}">
        @endforeach
    @endif

    {{--视频信息--}}
    <dl>
        @foreach($item->getAttributes() as $k=>$v)
            <dt>
                {{$k}}
            </dt>
            <dd>
                {{$v}}
            </dd>
        @endforeach
    </dl>

@endsection
@section('script')
    {{--加载WEB播放器SDK并调用--}}
    @if($item->video_type=='common')
        <script src="https://qzonestyle.gtimg.cn/open/qcloud/video/h5/h5connect.js" charset="utf-8"></script>
        <script type="text/javascript">

            (function () {
                var option = {
                    "auto_play": "1",
                    "file_id": "{{$item->cloud_file_id}}",
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
                    console.log('addBarrage called successfully');
                }, 1000);

            })();
        </script>
    @endif

    <script type="text/javascript">
        //        自己实现弹幕
        function addBarrage(barrage) {
            console.log(barrage);
            var $container = $('[component="center_container"]').parent();
            var $div = $('<div>').addClass('barrage');
            if (barrage.style) {
                $div.css('color', barrage.style.split(';')[0]);
            }
            $div.text(barrage.content);// $div.text('asdfasfasfsd');
            $container.append($div).css('overflow', 'hidden');
            $div.animate({left: '-' + $div.width() + 'px'}, 5000, 'linear').queue(function (next) {
                $(this).hide();
                next();
            });
        }
        var barrage = [
            {"type": "content", "content": "hello world", "time": "1"},
            {"type": "content", "content": "居中显示", "time": "1", "style": "C64B03;30", "position": "center"}
        ];
//        window.setTimeout(function () {
//            addBarrage(barrage);
//        }, 1000);
        $.each(barrage, function (k, v) {
            window.setTimeout(function () {
                addBarrage(v);
            }, 1000 * (k + 1));
        })

    </script>
@endsection
