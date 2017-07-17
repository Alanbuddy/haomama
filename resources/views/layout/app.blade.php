<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <base href={$ip=='127.0.0.1'?"/":"/haomama/}>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="format-detection", content: "telephone=no">
    <meta name="format-detection", content: "email=no">

    <title>
        @yield('title') VOD
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/mobile-notification.css">
    <link rel="stylesheet" href="css/layout.css">

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
<script src = "js/mobile-notification.js"></script>
<script src = "js/layout.js"></script>

@yield('script')
</body>
</html>
