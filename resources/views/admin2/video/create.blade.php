@extends('layout.app')
@section('content')
    @include('admin.video.menu')
    @include('common.message')
    <form action="{{route('videos.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{--<input type="text" name="name">--}}
        <input type="file" name="video">
        <button class="btn" type="submit">上传</button>
    </form>
@endsection
