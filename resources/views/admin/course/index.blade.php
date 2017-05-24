@extends('layout.app')
@section('content')
    @include('admin.course.menu')

    {{$items->total()}} records
    <ul>
        @foreach($items as $item)
            <li>
                [{{$item->id}}]
                {{$item->name}}
                <b>{{$item->status}}</b>
                <b>{{$item->created_at}}</b>
                <a href="{{route('courses.show',['course'=>$item->id])}}">
                    详细信息
                </a>
                <a href="{{route('courses.edit',['course'=>$item->id])}}">
                    编辑基本信息
                </a>
                <a href="{{route('courses.lessons.edit',['course'=>$item->id])}}">
                    选课
                </a>
                <a href="{{route('courses.tags.edit',['course'=>$item->id])}}">
                    标签
                </a>
                <a href="{{route('courses.comments.index',['course'=>$item->id])}}">
                    评论
                </a>
                <form action="{{route('courses.destroy',['id'=>$item->id])}}" method="post" style="display: inline">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button class="btn" type="submit">删除</button>
                </form>
            </li>
        @endforeach
    </ul>
    {{$items->render()}}
@endsection
