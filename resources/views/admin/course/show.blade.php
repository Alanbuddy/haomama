@extends('layout.app')

@section('css')
@endsection

@section('content')
    @include('common.message')
    @include('admin.course.menu')

    <dl>
        @foreach($course->getAttributes() as $k=>$v)
            <dt>
                {{$k}}
            </dt>
            <dd>
                {{$v}}
            </dd>
        @endforeach
        <dt>是否已加入</dt>
        <dd>{{$hasEnrolled?'yes':'no'}} </dd>
        <dd>已加入{{$enrolledCount}}人</dd>
        <dt>是否已收藏</dt>
        <dd>{{$hasFavorited?'yes':'no'}} </dd>
        <dt>课程</dt>
        <dd>{{count($lessons)}} </dd>
        <dt>评论</dt>
        <dd>{{count($comments)}} </dd>
    </dl>

@endsection

@section('script')
@endsection
