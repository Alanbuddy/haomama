@extends('layout.app')
@section('content')
    @include('admin.role.menu')
    @include('common.message')
    <form action="{{route('roles.store')}}" method="post" >
        {{csrf_field()}}
        <label for="name">name</label>
        <input type="text" name="name" placeholder="name">
        <label for="name">display_name</label>
        <input type="text" name="display_name" placeholder="display name">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
