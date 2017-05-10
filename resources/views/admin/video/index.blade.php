@extends('layout.app')
@section('content')
    @include('admin.video.menu')

    <ul>
        @foreach($items as $item)
            <li>
                {{$item->file_name}}
                <b>{{$item->video_type}}</b>
                <b>{{$item->created_at}}</b>
                <a href="{{route('video.cloud.info',['id'=>$item->id])}}">
                    云信息
                </a>
                <a href="{{route('video.cloud.transcode',['id'=>$item->id])}}">
                    转码中
                </a>
                <a href="{{route('videos.show',['id'=>$item->id])}}">
                    详细信息
                </a>
                <a href="{{route('videos.edit',['video'=>$item->id])}}">
                    编辑
                </a>
                <form action="{{route('videos.destroy',['id'=>$item->id])}}" method="post">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button class="btn" type="submit">删除</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
