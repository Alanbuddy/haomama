@extends('layout.app')

@section('title')
    Lesson index
@endsection

@section('content')
    @include('admin.setting.menu')

    {{$items->total()}} records
    <ul>
        @foreach($items as $item)
            <li>
                [{{$item->id}}]
                {{$item->name}}
                <b>{{$item->status}}</b>
                <b>{{$item->created_at}}</b>
                <a href="{{route('settings.show',['setting'=>$item->id])}}">
                    详细信息
                </a>
                <a href="{{route('settings.edit',['setting'=>$item->id])}}">
                    编辑
                </a>
                <form action="{{route('settings.destroy',['id'=>$item->id])}}" method="post" style="display: inline">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button class="btn" type="submit">删除</button>
                </form>
            </li>
        @endforeach
    </ul>
    {{$items->render()}}
@endsection
