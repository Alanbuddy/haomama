@extends('layout.app')
@section('content')
    @include('admin.setting.menu')
    @include('common.message')
    <form action="{{route('settings.store')}}" method="post" >
        {{csrf_field()}}
        <label for="name">name</label>
        <input type="text" name="key" placeholder="key">
        <label for="name">video</label>
        <input type="text" name="value" placeholder="value">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
