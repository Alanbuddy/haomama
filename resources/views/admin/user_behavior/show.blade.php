@extends('layout.app')

@section('css')
@endsection

@section('title')
    show
@endsection

@section('content')
    @include('common.message')
    @include('admin.user_behavior.menu')

    <dl>
        @foreach($item->getAttributes() as $k=>$v)
            <dt>
                {{$k}}
            </dt>
            <dd>
                {{$v}}
            </dd>
        @endforeach
    </dl>
@endsection

@section('script')
@endsection
