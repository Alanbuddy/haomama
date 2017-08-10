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
  window.lesson_del = "#{route('lessons.destroy',$lesson->id)}"

@endsection
@section('search-input')
%a{href: route('lessons.index')}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')
               
.main-content.bg2
  - if($canDelete)
    %button.btn.delete-normal.font-color1.delete-btn-position#delete-btn{type: "button"} 删除
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
                  %span.info= $audio->file_name
                  %p.state 原文件
                  %button.delete_btn 删除
                #thelist.uploader-list
                .btns
                  #picker 选择文件
                  %button#ctlBtn.btn.btn-default 开始上传
            %span.audio-id= $audio->id
            %span.video-id= $video->id
            .notice-introduce.introduce-flex
              %span.introduce 内容介绍:
              %span.unedit-box.introduce-span#desc-span!= $lesson['description']
              %span#desc-html{style: "display:none;"}= $lesson['description']
              %span.wangedit-area.edit-box
                #edit-box
            .img-file.margin20
              %span 图片文件:
              %span.unedit-box.unedit-img-box
                - foreach($pictures as $picture)
                  .img-item
                    %img.show-img{src: strpos($picture->path, '/')==0 ? substr($picture->path,1) : $picture->path}
                    // %p.img-index 01  //播放顺序，看需求需要添加吗
                    %p.img-time= $picture->pivot->no

              #uploader_img.wu-example.edit-box
                - foreach($pictures as $picture)
                  .old_pre_img
                    %p.img_wrap
                      %img{:src => strpos($picture->path, '/')==0 ? substr($picture->path,1) : $picture->path}
                    %h4.info_img= $picture->file_name
                    %img.old_delete_img{:src => "icon/admin/rubbish.png"}
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