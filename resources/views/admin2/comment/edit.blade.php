@extends('layout.app')
@section('content')
    @include('admin.comment.menu')
    @include('common.message')
    <form action="{{route('comments.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="name">content</label>
        <input type="text" name="content" placeholder="name" value="{{$item->content}}">
        <label for="name">Star</label>
        <input type="text" name="star" placeholder="name" value="{{$item->star}}">
        <label for="name">Course ID</label>
        <input type="text" name="course_id" placeholder="course_id" value="{{$item->course_id}}">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
