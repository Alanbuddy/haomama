@extends('layout.app')

@section('title')
    Lesson index
@endsection

@section('content')
    @include('admin.user_behavior.menu')

    {{$items->total()}} records
    <ul>
        @foreach($items as $item)
            <li>
                [{{$item->id}}]
                <b>{{$item->type}}</b>
                <b>{{$item->data}}</b>
                <b>{{$item->time}}</b>
                <b>{{$item->created_at}}</b>
                <a href="{{route('behaviors.show',['user-behavior'=>$item->id])}}">
                    详细信息
                </a>
                <a href="{{route('behaviors.edit',['user-behavior'=>$item->id])}}">
                    编辑
                </a>
                <form action="{{route('behaviors.destroy',['id'=>$item->id])}}" method="post" style="display: inline">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button class="btn" type="submit">删除</button>
                </form>
            </li>
        @endforeach
    </ul>
    {{$items->render()}}
@endsection
