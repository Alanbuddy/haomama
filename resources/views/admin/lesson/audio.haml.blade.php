@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_lesson_audio.css') }}">

<link href="/css/plugin/html5uploader.css" rel="stylesheet" type="text/css">

:javascript
    window.lesson_index = "#{route('lessons.index')}"
    window.lesson_store = "#{route('lessons.store')}"
    window.video = "#{route('videos.store')}"
    window.token = "#{csrf_token()}"
@endsection

@section('content')
.content-area
  .main-top.direction
    %a{href: route('lessons.index')}
      %img.back{src: "/icon/admin/back.png"}
    %ul.set
      %li
        %a.f16{href: route('users.index')} 人员管理
        .dot
      %li
        %a.f16.left-border{href: route('admin.profile')} 账号设置
      %li
        %a.f16.set-left-border#exit{href: "#"} 退出登录
    
  .main-content.bg2
    %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 保存
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 音频详情
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div.font-color3.f14
              .form-group
                %label.input-name.fn 课时标题:
                %input.form-control#input-caption{:type => "text"}
              .video-file
                %span 音频文件:
                %span#upload
              .notice-introduce.clearfix
                %span.introduce 内容介绍:
                %span.wangedit-area
                  #edit-box
              .video-file.margin20
                %span 图片文件:
                %span#upload_img
              .img-div.margin20
                

@endsection

@section('script')
<script src= "{{mix('/js/admin_lesson_audio.js')}}"></script>
<script src="/js/plugin/wangEditor.min.js"></script>
<script src="/js/plugin/jquery-ui.min.js"></script>
<script src="/js/plugin/jquery.js"></script>
<script src="/js/plugin/jquery.html5uploader.js"></script>

<script src="/js/fileupload.js"></script>

@endsection