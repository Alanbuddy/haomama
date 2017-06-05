@extends('layout.app')
@section('content')
    @include('admin.user_behavior.menu')
    @include('common.message')
    <form action="{{route('behaviors.store')}}" method="post" >
        {{csrf_field()}}
        <label for="name">type</label>
        <input type="text" name="type" placeholder="video.drag.begin" value="video.drag.begin">
        <label for="name">data</label>
        <input type="text" name="data" placeholder={"time":2} value={"time":2,"video_id":1}>
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
