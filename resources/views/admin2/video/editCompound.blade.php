@extends('layout.app')
@section('css')
    <script src="/js/Sortable.js"></script>
@endsection
@section('content')
    @include('admin.video.menu')
    @include('common.message')
    <form action="{{route('videos.update',$item->id)}}" method="post">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <input type="hidden" name="type" value="compound">
        <p>file name</p>
        <input type="text" name="name" value="{{$item->file_name}}">
        <button class="btn" type="submit">保存</button>
    </form>
    <form action="{{route('videos.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <input type="hidden" name="type" value="compound">
        <p>picture</p>
        <div id="pic">
            @foreach($pictures as $i)
                @if(strpos($i->mime,'image')===0)
                    <img data-id="{{$i->id}}" data-no="{{$i->no}}"
                         class="sort" src="{{$i->path}}" style="width:200px ;height: 140px;"
                         title="{{$i->file_name}}">
                @endif
            @endforeach
        </div>
        <input type="file" name="picture">
        <button class="btn" type="submit">上传</button>
    </form>
    <form action="{{route('videos.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <input type="hidden" name="type" value="compound">
        <p>audio</p>
        @if(!empty($audio))
            <audio src="{{$audio->path}}" controls></audio>
        @endif
        <input type="file" name="audio">
        <button class="btn" type="submit">上传</button>
    </form>
    <form action="{{route('videos.update',$item->id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <input type="hidden" name="type" value="compound">
        <p>title timeline(CSV)</p>
        <textarea cols="200">{{$item->caption}}</textarea><br>
        <input type="file" name="timeline">
        <button class="btn" type="submit">上传</button>
    </form>
    <script>
        var container = document.getElementById("pic");
        var updateUrl="{{route('video.attachment.order',$item->id)}}";
        var sort = Sortable.create(container, {
            animation: 150, // ms, animation speed moving items when sorting, `0` — without animation
//            handle: ".handle", // Restricts sort start click/touch to the specified element
            draggable: ".sort", // Specifies which items inside the element should be sortable
            onUpdate: function (evt/**Event*/) {
                console.log(evt);
                var item = evt.item; // the current dragged HTMLElement
                update();
            }
        });
        function update() {
            var $pictures = $('#pic').children('img');
            $pictures.each(function (k, v) {
                $(this).attr('data-no', k);
                console.log($(this).data('id'));
                console.log(k);
                console.log(v);
            });
            var data = [];
            $pictures.each(function (k, v) {
                data.push({
                    id: $(v).data('id'),
                    no: $(v).data('no'),
                })
            });
            $.ajax({
                url: updateUrl,
                type: 'get',
                data: {
                    data:data,
                },
                success: function (response) {
                    console.log(response);
                }
            })
        }
        //        sort.destroy();
    </script>
@endsection
