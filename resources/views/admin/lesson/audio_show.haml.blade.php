@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_lesson_audio_show.css') }}">
<link href="css/plugin/webuploader.css" rel="stylesheet" type="text/css">

:javascript
    window.lesson_index = "#{route('lessons.index')}"
    window.lesson_store = "#{route('lessons.store')}"
    window.video = "#{route('videos.store')}"
    window.token = "#{csrf_token()}"
    window.files_merge = "#{route('files.merge')}"
    window.audio_init = "#{route('file.upload.init')}"
    window.admin_lesson_show = "#{route('admin.lesson.show', -1)}" 
    window.lesson_update = "#{route('lessons.update',$lesson->id)}"
@endsection

@section('content')
.content-area
  .main-top.direction
    %a{href: route('lessons.index')}
      %img.back{src: "icon/admin/back.png"}
    %ul.set
      %li
        %a.f16{href: route('users.index')."?type=operator"} 人员管理
        .dot
      %li
        %a.f16.left-border{href: route('admin.profile')} 账号设置
      %li
        %a.f16.set-left-border#exit{href: "#"} 退出登录
               
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
                %span.unedit-box#name-span= $lesson['name']
                %span.lesson-id{style: "display: none;"}= $lesson['id']
                %span.edit-box
                  %input.form-control#input-caption{:type => "text"}
              .video-file.introduce-flex
                %span 音频文件:
                %span.unedit-box
                  .caption-item
                    %img{src: "icon/admin/music-small.png"}
                    %span= $audio['file_name']
                #uploader.wu-example.edit-box
                  .item#old-video
                    %h4.info= $audio->file_name
                    %p.state 原视频
                    %button.delete_btn 删除
                  #thelist.uploader-list
                  .btns
                    #picker 选择文件
                    %button#ctlBtn.btn.btn-default 开始上传
              %span.audio-id= $audio->id
              %span.video-id= $video->id
              .notice-introduce.introduce-flex
                %span.introduce 内容介绍:
                %span.unedit-box.introduce-span#desc-span= strip_tags(htmlspecialchars_decode($lesson['description']))
                %span.wangedit-area.edit-box
                  #edit-box
              .img-file.margin20
                %span 图片文件:
                %span.unedit-box.unedit-img-box
                  - foreach($pictures as $picture)
                    .img-item
                      %img.show-img{src: $picture->path}
                      // %p.img-index 01
                      %p.img-time= $picture->pivot->no

                #uploader_img.wu-example.edit-box
                  - foreach($pictures as $picture)
                    .old_pre_img
                      %p.img_wrap
                        %img{:src => $picture->path}
                      %h4.info_img= $picture->file_name
                      %img.old_delete_img{:src => "/icon/admin/rubbish.png"}
                      %span.old-data-id= $picture->id
                      %input.old_img_time{:placeholder => "请输入时间", value: $picture->pivot->no}
                  .btns
                    #picker_img 选择文件
                    %button#imgBtn.btn.btn-default 开始上传
              #imglist.uploader-list.img-div.margin20.edit-box
                

@endsection

@section('script')
<script src="js/plugin/wangEditor.min.js"></script>
<script src="js/plugin/jquery-ui.min.js"></script>
<script src="js/plugin/webuploader.js"></script>
<script src="js/audio_edit.js"></script>

@endsection