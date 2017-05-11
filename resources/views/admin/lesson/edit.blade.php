@extends('layout.app')
@section('content')
    @include('admin.lesson.menu')
    @include('common.message')
    <form action="{{route('lessons.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="name">name</label>
        <input type="text" name="name" placeholder="name" value="{{$item->name}}">
        <label for="name">video</label>
        <input type="text" name="video_id" placeholder="video id" value="{{$item->video_id}}">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
