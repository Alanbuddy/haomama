@extends('layout.app')
@section('content')
    @include('common.message')
    <ul>
        <li>
            <a href="{{route('videos.index')}}">Videos</a>
        </li>
        <li>
            <a href="{{route('courses.index')}}">courses</a>
        </li>
        <li>
            <a href="{{route('lessons.index')}}">lessons</a>
        </li>
    </ul>
@endsection
