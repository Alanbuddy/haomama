@extends('layout.app')
@section('content')
    @include('admin.video.menu')
    @include('common.message')
    <form action="{{route('videos.update',$item->id)}}" method="post">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <input type="hidden" name="type" value="compound">
        <p>file name</p>
        <input type="text" name="name" value="{{$item->file_name}}">
        <button class="btn" type="submit">保存</button>
    </form>
@endsection
