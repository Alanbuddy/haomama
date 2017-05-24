@extends('layout.app')
@section('content')
    @include('admin.order.menu')
    @include('common.message')
    <form action="{{route('orders.store')}}" method="post">
        {{csrf_field()}}
        <label for="name">title</label>
        <input type="text" name="name" placeholder="name">
        <label for="name">product/course id</label>
        <input type="text" name="course_id" placeholder="course">
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
