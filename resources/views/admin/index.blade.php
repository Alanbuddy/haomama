@extends('layout.app')
@section('content')
    @include('common.message')
    <ul>
        <li>
            <a href="{{route('videos.index')}}">Videos</a>
        </li>
    </ul>
@endsection
