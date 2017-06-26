@extends('layout.app')
@section('content')
    @include('admin.role.menu')
    @include('common.message')
    <form action="{{route('roles.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="name">name</label>
        <input type="text" name="name" placeholder="name" value="{{$item->name}}">
        <label for="name">video</label>
        <input type="text" name="display_name" placeholder="display_name" value="{{$item->display_name}}">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
