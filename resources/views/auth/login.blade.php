@extends('layout.app')
@section('content')
    @include('common.message')
    <form action="{{route('login',[],false)}}" method="post">
        {{--<form action="{{route('login')}}" method="post">--}}
        {{csrf_field()}}
        <input type="email" name="email" value="" placeholder="email">
        <input type="password" name="password">
        <input type="checkbox" name="remember" placeholder="checkbox">
        <button>Login</button>
    </form>
    <a href="#" id="wechat">wechat Login</a>

@endsection
@section('script')
    <script>
        var appId = "{{config('wechat.mp.appId')}}";
        var node = document.getElementById('wechat');
        var app_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid="
            + appId
            + "&redirect_uri=http%3a%2f%2fhttp://baby.fumubidu.com.cn/haomama/wechat/login" +
            "&response_type=code" +
            "&scope=snsapi_userinfo&state=STATE" +
            "&connect_redirect=1#wechat_redirect";
        node.setAttribute('href', app_url);
    </script>
@endsection
