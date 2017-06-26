@extends('layout.app')

@section('css')
@endsection

@section('title')
    Lesson show
@endsection

@section('content')
    @include('common.message')
    @include('admin.lesson.menu')

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

    <h2>video info</h2>
    {{$item->video->id}}
    {{$item->video->file_name}}
    {{$item->video->video_type}}
@endsection

@section('script')
@endsection
