@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_course_offline.css') }}">
<link href="/css/plugin/jquery.tag-editor.css" rel="stylesheet" type="text/css">

:javascript
  window.course_index = "#{route('courses.index')}"
  window.token = "#{csrf_token()}"
@endsection

@section('content')
.content-area
  .main-top.direction
    %a{href: route('courses.index')}
      %img.back{src: "/icon/admin/back.png"}
    %ul.set
      %li
        %a.f16{href: "#"} 人员管理
        .dot
      %li
        %a.f16.left-border{href: "#"} 账号设置
      %li
        %a.f16.set-left-border{href: "#"} 退出登录

  .main-content.bg2
    %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 保存
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 课程详情
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div.font-color3.clearfix.f14
              .text-message
                .controls.controls-row.margin20
                  %label.input-caption 课程名称:
                  %input.input-area.form-control#course-name{:type => "text", placeholder: "必填"}
                .controls.controls-row
                  %label.input-caption 课程类型:
                  %select.form-control.input-width#course-type
                    %option 请选择类型
                    %option{value: "类型一"} 类型一
                    %option{value: "类型二"} 类型二
                    %option{value: "类型三"} 类型三
                  %label.input-caption 课程节数:
                  %input.form-control.input-width{:type => "text"}
                .controls.controls-row
                  %label.input-caption 课程价格:
                  %input.form-control.input-width#course-price{:type => "text"}
                  %label.input-caption 促销价格:
                  %input.form-control.input-width{:type => "text"}
              %input#previewImg{:onchange => "previewImage(this)", :type => "file", style: "display:none;"}
              .photo#preview
                %img.edit-photo#imghead{src: "/icon/admin/photo-course.png", onclick: "$('#previewImg').click()"}
                
            .controls-div.font-color3.f14
              .controls.controls-row
                %label.input-caption 课程标签:  
                %span.tag-div
                  #type-tag
                .hot-tag-div
                  %span 标签一
                  %span 标签一
                  %span 标签十分大
              .controls.controls-row.no-mb
                %label.input-caption 授课老师:
                %span 未添加
              .teacher-div
                #teacher-tag
                .hot-tag-hide
                  %p.tag-word 热词一 
                  %p.tag-word 热词一 
                  %p.tag-word 热词一 

              .course-introduce
                %span.introduce 课程介绍:
                %span.wangedit-area
                  #edit-area
              .course-lesson
                %span.introduce 选择课时:
                %span.addlesson 添加
              .lesson-div
                %span.introduce 课时标题:
                %ul.lesson-title
                  %li 11111
@endsection
#lessonModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/admin/delete1.png"}
      .modal-body
        .courses-div
          .item.course-video
            %img{src: "/icon/admin/media.png"}
            %p 音/视频课程
          .item.offline
            %img{src: "/icon/admin/class.png"}
            %p 线下课程

@section('script')
<script src= "{{mix('/js/admin_course_offline.js')}}"></script>
<script src="/js/plugin/jquery-ui.min.js"></script>
<script src="/js/plugin/wangEditor.min.js"></script>
<script src="/js/plugin/jquery.tag-editor.min.js"></script>
// <script src="/js/preview.js"></script>
// <script src="/js/lesson-title.js"></script>

@endsection