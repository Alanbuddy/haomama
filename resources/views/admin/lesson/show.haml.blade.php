@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_lesson_show.css') }}">
<link href="/css/plugin/webuploader.css" rel="stylesheet" type="text/css">

:javascript
    window.lesson_index = "#{route('lessons.index')}"
    window.lesson_store = "#{route('lessons.store')}"
    window.video = "#{route('videos.store')}"
    window.token = "#{csrf_token()}"
    window.merge = "#{route('videos.merge')}"
    window.init = "#{route('videos.upload.init')}"
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
  //  视频课时详情页 
  // .main-content.bg2
  //   %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{type: "button"} 编辑
  //   %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 保存
  //   .table-div
  //     .tabbable
  //       %ul.nav.nav-tabs
  //         %li.active
  //           %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 视频详情
  //       .tab-content.bg3
  //         #tab1.tab-pane.active
  //           .desc-div.font-color3.f14
  //             .form-group
  //               %label.input-name.fn 课时标题:
  //               %span.unedit-box 这里是视频课时的标题
  //               %span.edit-box
  //                 %input.form-control#input-caption{:type => "text"}
  //             .video-file.introduce-flex
  //               %span 视频文件:
  //               %span.unedit-box
  //                 .caption-item
  //                   %img{src: "/icon/admin/video-small.png"}
  //                   %span 这里是视频课时的标题
  //               #uploader.wu-example.edit-box
  //                 #thelist.uploader-list
  //                 .btns
  //                   #picker 选择文件
  //                   %button#ctlBtn.btn.btn-default 开始上传
  //             %span.video-id
             
  //             .notice-introduce.introduce-flex
  //               %span.introduce 内容介绍:
  //               %span.unedit-box.ml4.introduce-span 该课程是少儿类视频第一名该课程是少儿类视频第一名该课程是少儿类视频第一名该课程是少儿类视频第一名该课程是少儿类视频第一名该课程是少儿类视频第一名该课程是少儿类视频第一名
  //               %span.edit-box.wangedit-area
  //                 #edit-box

  .main-content.bg2
    %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{type: "button"} 编辑
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
                %span.unedit-box 这里是视频课时的标题
                %span.edit-box
                  %input.form-control#input-caption{:type => "text"}
              .video-file.introduce-flex
                %span 音频文件:
                %span.unedit-box
                  .caption-item
                    %img{src: "/icon/admin/music-small.png"}
                    %span 这里是视频课时的标题
                #uploader.wu-example.edit-box
                  #thelist.uploader-list
                  .btns
                    #picker 选择文件
                    %button#ctlBtn.btn.btn-default 开始上传
              .notice-introduce.introduce-flex
                %span.introduce 内容介绍:
                %span.unedit-box.introduce-span 该课程是少儿类视频第一名该课程是少儿类视频第一名该课程是少儿类视频第一名该课程是少儿类视频第一名该课程是少儿类视频第一名该课程
                %span.wangedit-area.edit-box
                  #edit-box
              .video-file.margin20
                %span 图片文件:
                %span.unedit-box.unedit-img-box
                  .img-item
                    %img.show-img{src: "/icon/example.png"}
                    %p.img-index 01
                    %p.img-time 00:01:23
                  .img-item
                    %img.show-img{src: "/icon/example.png"}
                    %p.img-index 01
                    %p.img-time 00:01:23
                  .img-item
                    %img.show-img{src: "/icon/example.png"}
                    %p.img-index 01
                    %p.img-time 00:01:23
                  .img-item
                    %img.show-img{src: "/icon/example.png"}
                    %p.img-index 01
                    %p.img-time 00:01:23
                  .img-item
                    %img.show-img{src: "/icon/example.png"}
                    %p.img-index 01
                    %p.img-time 00:01:23
                  .img-item
                    %img.show-img{src: "/icon/example.png"}
                    %p.img-index 01
                    %p.img-time 00:01:23
                  .img-item
                    %img.show-img{src: "/icon/example.png"}
                    %p.img-index 01
                    %p.img-time 00:01:23
                #uploader_img.wu-example.edit-box
                  
                  .btns
                    #picker_img 选择文件
                    %button#imgBtn.btn.btn-default 开始上传
              #imglist.uploader-list.img-div.margin20.edit-box 



@endsection

@section('script')
<script src= "{{mix('/js/admin_lesson_show.js')}}"></script>
<script src="/js/plugin/wangEditor.min.js"></script>
<script src="/js/plugin/jquery-ui.min.js"></script>
<script src="/js/plugin/webuploader.js"></script>

// <script src="/js/fileupload.js"></script>    视频课时详情页用

<script src="/js/fileupload_audio.js"></script>

@endsection