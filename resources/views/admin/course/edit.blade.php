@extends('layout.app')
@section('content')
    @include('admin.course.menu')
    @include('common.message')
    <form action="{{route('courses.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="name">name</label>
        <input type="text" name="name" placeholder="name" value="{{$item->name}}">
        <label for="name">price</label>
        <input type="text" name="price" placeholder="price 0.00" value="{{$item->price}}">
        <label for="name">begin</label>
        <input type="text" name="begin" placeholder="begin at" value="{{$item->begin}}">
        <label for="name">end</label>
        <input type="text" name="end" placeholder="end at" value="{{$item->end}}">
        <label for="name">teacher id</label>
        <input type="text" name="teacherId" placeholder="end at" value="{{$item->teacher_id}}">
        <label for="description">description</label>
        <textarea name="description" placeholder="description">
            {{$item->description}}
        </textarea>
        <label for="cover">cover</label>
        <img src="{{$item->cover}}">
        <input type="file" name="cover">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
