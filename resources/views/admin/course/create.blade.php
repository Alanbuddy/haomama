@extends('layout.app')
@section('content')
    @include('admin.course.menu')
    @include('common.message')
    <form action="{{route('courses.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <label for="name">name</label>
        <input type="text" name="name" placeholder="name">
        <label for="name">price</label>
        <input type="text" name="price" placeholder="price 0.00">
        <label for="description">description</label>
        <textarea name="description" placeholder="description">
        </textarea>
        <label for="cover">cover</label>
        <input type="file" name="cover">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
