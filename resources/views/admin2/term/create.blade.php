@extends('layout.app')
@section('content')
    @include('admin.term.menu')
    @include('common.message')
    <form action="{{route('terms.store')}}" method="post">
        {{csrf_field()}}
        <label for="name">name</label>
        <input type="text" name="name" placeholder="name">
        <label for="name">type</label>
        <select name="type">
            <option value="tag">tag</option>
            <option value="category">category</option>
        </select>
        <button class="btn" type="submit">提交</button>
    </form>
@endsection
