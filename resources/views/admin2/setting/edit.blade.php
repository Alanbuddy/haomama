@extends('layout.app')
@section('content')
    @include('admin.setting.menu')
    @include('common.message')
    <form action="{{route('settings.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="name">key</label>
        <input type="text" name="key" placeholder="name" value="{{$item->key}}">
        <label for="name">value</label>
        <input type="text" name="value" placeholder="value" value="{{$item->value}}">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
