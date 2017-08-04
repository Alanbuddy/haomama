<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <base href={{$base_href}}>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="format-detection", content: "telephone=no">
    <meta name="format-detection", content: "email=no">

    <title>
        @yield('title') 好妈妈微课
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/mobile-notification.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/plugin/dropload.css">

    @yield('css')
</head>
<body>
<div>
    @yield('header')
</div>
<div class="wrapper">
    @yield('content')
   <!--  <div class="row">
        <ul class="nav navbar-nav navbar-right"> -->
            <!-- Authentication Links -->

           {{--  @if (Auth::guest())
                {{--<li><a href="{{ route('login') }}">Login</a></li>--}}
                {{-- <li><a href="{{ route('login',[],false) }}">Login</a></li> --}}
                {{--<li><a href="{{ route('register') }}">Register</a></li>--}}
                {{-- <li><a href="{{ route('register',[],false) }}">Register</a></li> --}}

           {{--  @else --}}
                {{-- @role('admin') --}}
                {{-- <li><a href="{{route('admin.index',[],false) }}"> --}}
                        {{-- <p>admin</p> --}}
                    {{-- </a> --}}
                {{-- </li> --}}

                {{-- @endrole --}}
                {{-- <li class="dropdown"> --}}
                    {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> --}}
                        {{-- {{ Auth::user()->name }} <span class="caret"></span> --}}
                    {{-- </a> --}}
                {{-- </li> --}}

                {{-- <li> --}}
                    {{-- <form class="navbar-form navbar-left" action="{{route('logout',[],false)}}" method="post"> --}}
                        {{-- {{csrf_field()}} --}}
                        {{-- <button type="submit" class="btn btn-sm btn-danger">Logout</button> --}}
                    {{-- </form> --}}
                {{-- </li> --}}
            {{-- @endif --}}
        {{-- </ul> --}}
    {{-- </div> --}}

</div>
<div>
    @yield('foot-div')
</div>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src ="js/ajax.js"></script>
<script src = "js/regex.js"></script>
<script src= "http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src = "js/mobile-notification.js"></script>
<script src = "js/plugin/dropload.min.js"></script>

<script src= "{{mix('/js/layout.js')}}"></script>
<script>
  wx.config({
      debug: false,
      appId: '{{ $signPackage["appId"]}}',
      timestamp: '{{ $signPackage["timestamp"]}}',
      nonceStr: '{{ $signPackage["nonceStr"]}}',
      signature: '{{ $signPackage["signature"]}}',
      jsApiList: [
          // 所有要调用的 API 都要加到这个列表中
          'onMenuShareTimeline',
          'scanQRCode',
          'hideAllNonBaseMenuItem'
      ]
  });
  wx.ready(function () {
      // 在这里调用 API
  //            wx.hideAllNonBaseMenuItem();
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

//      wx.getLocation({
//          type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
//          success: function (res) {
//              var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
//              var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
//              var speed = res.speed; // 速度，以米/每秒计
//              var accuracy = res.accuracy; // 位置精度
//              alert(res);
//          }
//      });
//
//      wx.scanQRCode({
//          needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
//          scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
//          success: function (res) {
//              var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
//              alert(JSON.stringify(result));
//          }
//      });

  });



  var appId = "{{config('wechat.mp.app_id')}}";
  var vodId = "{{config('services.vod.appId')}}";
  var app_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid="
      + appId
      + "&redirect_uri=http%3a%2f%2f"
      + "baby.fumubidu.com.cn/haomama/wechat/login&response_type=code&scope=snsapi_userinfo&state=STATE&connect_redirect=1#wechat_redirect";

  @if(!Auth::check())
  if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) == 'micromessenger') {
      location.href =  app_url;
  }
  @endif
  // if ((navigator.userAgent.match(/(iPhone|iPod|Android|ios|SymbianOS)/i))) {
  //     if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) == 'micromessenger') {
  //         node.setAttribute('href', app_url);
  //     }
  // if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) == 'micromessenger') {
  //     location.href =  app_url;
  // }

  // var snsapi_base_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid="
  //     + appId
  //     + "&redirect_uri=http%3a%2f%2f"
  //     + "baby.fumubidu.com.cn/haomama/wechat/openid&response_type=code&scope=snsapi_base&state=STATE&connect_redirect=1#wechat_redirect";
</script>

@yield('script')
</body>
</html>
