@extends('layout.app')
@section('content')
    @include('admin.user.menu')
    @include('common.message')
    <form action="{{route('users.store')}}" method="post" >
        {{csrf_field()}}
        <label for="name">name</label>
        <input type="text" name="name" placeholder="name">
        <label for="name">role</label>
        <input type="text" name="role_id" placeholder="role id">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
