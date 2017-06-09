@extends('layout.app')
@section('content')
    @include('admin.lesson.menu')
    @include('common.message')
    <form action="{{route('lessons.store')}}" method="post" >
        {{csrf_field()}}
        <label for="name">name</label>
        <input type="text" name="name" placeholder="name">
        <label for="name">video</label>
        <input type="text" name="video_id" placeholder="video id">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
