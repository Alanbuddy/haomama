<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title') VOD
    </title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    @yield('css')
</head>
<body>
<div class="container">
    <div class="row">
        <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->

            @if (Auth::guest())
                {{--<li><a href="{{ route('login') }}">Login</a></li>--}}
                <li><a href="{{ route('login',[],false) }}">Login</a></li>
                {{--<li><a href="{{ route('register') }}">Register</a></li>--}}
                <li><a href="{{ route('register',[],false) }}">Register</a></li>

            @else
                @role('admin')
                <li><a href="{{route('admin.index',[],false) }}">
                        <p>admin</p>
                    </a>
                </li>

                @endrole
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                </li>

                <li>
                    <form class="navbar-form navbar-left" action="{{route('logout',[],false)}}" method="post">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                    </form>
                </li>
            @endif
        </ul>
    </div>
    @yield('content')
</div>
<script src="/js/jquery-3.2.1.min.js"></script>
@yield('script')
</body>
</html>
