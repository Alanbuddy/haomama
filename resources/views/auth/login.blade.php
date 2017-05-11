@extends('layout.app')
@section('content')
    @include('common.message')
    <form action="{{route('login')}}" method="post">
        {{csrf_field()}}
        <input type="email" name="email" value="" placeholder="email">
        <input type="password" name="password">
        <input type="checkbox" name="remember" placeholder="checkbox">
        <button>Login</button>
    </form>

@endsection
