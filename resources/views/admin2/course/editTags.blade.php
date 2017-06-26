@extends('layout.app')
@section('content')
    @include('admin.course.menu')
    @include('common.message')
    <form action="{{route('courses.tags.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="name">Tags</label>
        <input type="text" name="lessons" placeholder="tags id array"
               value="@foreach($tags as $item) {{$item->id}} @if($loop->last)@else,@endif @endforeach">
        <button class="btn" type="submit">提交</button>
    </form>
    <hr>
    @foreach($tags as $item)
        {{$item->id}}: {{$item->name}}<br>
    @endforeach
@endsection
