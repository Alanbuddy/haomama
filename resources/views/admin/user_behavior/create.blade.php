@extends('layout.app')
@section('content')
    @include('admin.user_behavior.menu')
    @include('common.message')
    <form action="{{route('behaviors.store')}}" method="post" xmlns:10="http://www.w3.org/1999/xhtml">
        {{csrf_field()}}
        <label for="name">type</label>
        <input type="text" name="type" placeholder="video.drag.begin" value="video.drag.begin">
        <label for="name">data</label>
        <input type="text" name="data" placeholder={"time":2} value={"time":2,"video_id":1}>
        <button class="btn" type="submit">提交开始拖动行为</button>
    </form>
    <form action="{{route('behaviors.store')}}" method="post">
        {{csrf_field()}}
        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="video.drag.end">
        <label for="name">data</label>
        <input type="text" name="data" placeholder='' value={"time":23,"video_id":1}>
        <button class="btn" type="submit">提交结束拖动行为</button>
    </form>
    <form action="{{route('behaviors.store')}}" method="post">
        {{csrf_field()}}
        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="video.play">
        <label for="name">data</label>
        <input type="text" name="data" placeholder={"time":2} value={"video_id":1}>
        <button class="btn" type="submit">提交播放视频行为</button>
    </form>
    <form action="{{route('behaviors.store')}}" method="post">
        {{csrf_field()}}
        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="video.share">
        <label for="name">data</label>
        <input type="text" name="data" placeholder="" value={"video_id":1}>
        <button class="btn" type="submit">提交分享视频行为</button>
    </form>
    <form action="{{route('behaviors.store')}}" method="post">
        {{csrf_field()}}
        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="video.watch">
        <label for="name">data</label>
        <input type="text" name="data" placeholder="" value={"video_id":1}>
        {{--<label for="name">user_id</label>--}}
        {{--<input type="text" name="user_id" placeholder="" value=1>--}}
        <label for="name">video_id</label>
        <input type="text" name="video_id" placeholder="" value=1>
        <label for="name">lesson_id</label>
        <input type="text" name="lesson_id" placeholder="" value=1>
        <button class="btn" type="submit">提交观看视频行为</button>
    </form>
    <form action="{{route('behaviors.store')}}" method="post">
        {{csrf_field()}}
        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="pv.begin">
        <label for="name">data</label>
        <input type="text" name="data" placeholder="" value={"url":"/","time":"2017-2-32" }>
        <label for="name">video_id</label>
        <input type="text" name="course_id" placeholder="" value=>
        <label for="name">lesson_id</label>
        <input type="text" name="lesson_id" placeholder="" value=>
        <button class="btn" type="submit">PV.begin 首页</button>
    </form>
    <form action="{{route('behaviors.store')}}" method="post">
        {{csrf_field()}}
        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="pv.begin">
        <label for="name">data</label>
        <input type="text" name="data" placeholder="" value={{json_encode(['url'=>'/courses/1','time'=>'2017-8-8']) }}>
        <label for="name">video_id</label>
        <input type="text" name="course_id" placeholder="" value=>
        <label for="name">lesson_id</label>
        <input type="text" name="lesson_id" placeholder="" value=>
        <button class="btn" type="submit">PV.begin 课时详情页面</button>
    </form>
    <form action="{{route('behaviors.store')}}" method="post">
        {{csrf_field()}}
        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="pv.end">
        <label for="name">data</label>
        <input type="text" name="data" placeholder="" value={{json_encode(['url'=>'/courses/1','time'=>'2017-8-9']) }}>
        <label for="name">video_id</label>
        <input type="text" name="course_id" placeholder="" value=>
        <label for="name">lesson_id</label>
        <input type="text" name="lesson_id" placeholder="" value=>
        <button class="btn" type="submit">PV.end 课时详情页面</button>
    </form>
    <form action="{{route('behaviors.store')}}" method="post">
        {{csrf_field()}}
        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="pv.end">
        <label for="name">data</label>
        <input type="text" name="data" placeholder="" value={{json_encode(['url'=>'/courses/search?key=a','time'=>'2017-8-8']) }}>
        <button class="btn" type="submit">PV搜索</button>
    </form>
    <form action="{{route('behaviors.store')}}" method="post">
        {{csrf_field()}}
        <label for="name">type</label>
        <input type="text" name="type" placeholder="" value="pv.end">
        <label for="name">data</label>
        <input type="text" name="data" placeholder="" value={{json_encode(['url'=>route('user.profile',auth()->user()),'time'=>'2017-8-8']) }}>
        <button class="btn" type="submit">PV个人资料</button>
    </form>
@endsection
