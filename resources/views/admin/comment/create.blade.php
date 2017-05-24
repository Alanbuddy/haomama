@extends('layout.app')
@section('content')
    @include('admin.comment.menu')
    @include('common.message')
    <form action="{{route('comments.store')}}" method="post" >
        {{csrf_field()}}
        <label for="name">Content</label>
        <input type="text" name="content" placeholder="content">
        <label for="name">Star</label>
        <input type="text" name="star" placeholder="star">
        <label for="name">Course ID</label>
        <input type="text" name="course_id" placeholder="course_id">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
