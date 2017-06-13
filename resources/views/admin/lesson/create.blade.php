@extends('layout.app')
@section('content')
    @include('admin.lesson.menu')
    @include('common.message')
    <form action="{{route('lessons.store')}}" method="post" >
        {{csrf_field()}}
        <label for="name">name</label>
        <input type="text" name="name" placeholder="name" value="{{str_random(4)}}">
        <label for="name">video</label>
        <input type="text" name="video_id" placeholder="video id" value="1">
        <label for="name">begin</label>
        <input type="text" name="begin" placeholder="" value="{{ date('Y-m-d H:i:s', strtotime("+1 day"))}}">
        <label for="name">end</label>
        <input type="text" name="end" placeholder="" value="{{ date('Y-m-d H:i:s', strtotime("+1 week"))}}">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
