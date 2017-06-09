@extends('layout.app')
@section('content')
    @include('admin.user.menu')
    @include('common.message')
    <form action="{{route('users.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <label for="name">name</label>
        <input type="text" name="name" placeholder="name" value="{{$item->name}}">
        <label for="role"></label>
        <input type="text" name="roles" placeholder="role id" value="
        @if(count($roles))
        @foreach($roles as $role){{$role->id}}@if(!$loop->last),@endif @endforeach
        @endif
                ">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
