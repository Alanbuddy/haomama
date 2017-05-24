@extends('layout.app')
@section('content')
    @include('admin.course.menu')
    @include('common.message')
    <form action="{{route('courses.lessons.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="name">lessons</label>
        <input type="text" name="lessons" placeholder="lessons id array"
               value="@foreach($lessons as $item) {{$item->id}} @if($loop->last)@else,@endif @endforeach">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
