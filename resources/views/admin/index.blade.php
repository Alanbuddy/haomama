@extends('layout.app')
@section('content')
    @include('common.message')
    <ul>
        <li>
            <a href="{{route('videos.index')}}">Video</a>
        </li>
        <li>
            <a href="{{route('courses.index')}}">Course</a>
        </li>
        <li>
            <a href="{{route('lessons.index')}}">Lesson</a>
        </li>
        <li>
            <a href="{{route('comments.index')}}">Comment</a>
        </li>
        <li>
            <a href="{{route('terms.index')}}?type=tag">Tag</a>
        </li>
        <li>
            <a href="{{route('terms.index')}}?type=category">Category</a>
        </li>
        <li>
            <a href="{{route('orders.index')}}">Order</a>
        </li>
        <li>
            <a href="{{route('users.index')}}">User</a>
        </li>
        <li>
            <a href="{{route('settings.index')}}">Setting</a>
        </li>
        <li>
            <a href="{{route('roles.index')}}">Role</a>
        </li>
    </ul>
@endsection
