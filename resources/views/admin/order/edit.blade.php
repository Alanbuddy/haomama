@extends('layout.app')
@section('content')
    @include('admin.term.menu')
    @include('common.message')
    <form action="{{route('terms.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="name">name</label>
        <input type="text" name="name" placeholder="name" value="{{$item->name}}">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
