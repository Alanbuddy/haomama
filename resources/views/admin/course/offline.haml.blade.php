@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_course_offline.css') }}">
<link rel="stylesheet" href="css/plugin/jquery-ui.css">
<link href="css/plugin/jquery.tag-editor.css" rel="stylesheet" type="text/css">
<link href="css/plugin/fullcalendar.min.css" rel="stylesheet" type="text/css">
<link href="css/plugin/jquery.timepicker.css" rel="stylesheet" type="text/css">


:javascript
  window.course_index = "#{route('courses.index')}"
  window.course_store = "#{route('courses.store')}"
  window.admin_course_show = "#{route('admin.courses.show', -1)}"
  window.token = "#{csrf_token()}"
  window.add_teacher = "#{route('users.search')}"
  window.tag_store = "#{route('terms.store')}"
  window.tag_destroy = "#{route('terms.destroy',-1)}"
@endsection
@section('search-input')
%a{href: route('courses.index')}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')

.main-content.bg2

  %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 保存
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li.active
          %a.f16.font-color1 课程详情
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
                  - foreach ($categories as $category )
                    %option{value: $category->id}= $category->name
                %label.input-caption 课程节数:
                %input.form-control.input-width#course-length{:type => "text", placeholder: "必填"}
              .controls.controls-row
                %label.input-caption 课程价格:
                %input.form-control.input-width#course-price{:type => "text", placeholder: "必填"}
                %label.input-caption 促销价格:
                %input.form-control.input-width#pay-price{:type => "text"}
            %input#previewImg{:onchange => "previewImage(this)", :type => "file", style: "display:none;"}
            .photo#preview
              %img.edit-photo#imghead{src: "icon/admin/photo-course.png", onclick: "$('#previewImg').click()"}
            %span.cover-path{style: "display:none;"}

          .controls-div.font-color3.f14
            .controls.controls-row
              %label.input-caption 上课时间:
              %input.form-control.input-width#lesson-date{:type => "text"}
              %label.input-caption 最少人数:
              %input.form-control.input-width#min-num{:type => "text", placeholder: "必填"}
            .controls.controls-row
              %label.input-caption 上课地点:
              %input.form-control.input-width#lesson-address{:type => "text"}
              %label.input-caption 最多人数:
              %input.form-control.input-width#max-num{:type => "text", placeholder: "必填"}
            .controls.controls-row
              %label.input-caption 课程标签:  
              %span.tag-div
                #type-tag
              .hot-tag-div
                - foreach($popularTags as $tag)
                  %span{value: $tag->id}= $tag->name
            .create-tag-div{style: "display:none"}

            .controls.controls-row.no-mb
              %label.input-caption.teacher-tag 授课老师:
              %span.unadd 未添加
            .teacher-div
              %input#teacher{type: "text", placeholder: "必填"}

            .calendar-wrapper.clearfix
              .calendar-operation-wrapper
                %p.title 课程日历
                %p.small-tips （单击日历中的时间进行删除）
                .form-inline
                  %label.input-date 上课日期:
                  %input.input-area.form-control.no-margin-right#datepicker{:type => "text"}
                .form-inline
                  %label.input-date 开始时间:
                  %input.input-area.form-control.no-margin-right#start-time{:type => "text"}
                .form-inline
                  %label.input-date 结束时间:
                  %input.input-area.form-control.no-margin-right#end-time{:type => "text"}
                .btn#add-event{:type => "button"} 添加单次
                .repeat.clearfix
                  %button.btn.date-btn#date-btn{:type => "button"} 次日重复
                  %button.btn.week-btn#week-btn{:type => "button"} 每周重复
              #calendar
            .course-introduce
              %span.introduce 课程介绍:
              %span.wangedit-area
                #edit-area
            .lesson-div
              %span.introduce 课时标题:
              %span.wangedit-area
                #edit-title
                  %p 必填,并且要与课程节数互相匹配
                  
@endsection

@section('script')
<script src="js/plugin/jquery-ui.min.js"></script>
<script src="js/plugin/wangEditor.min.js"></script>
<script src="js/plugin/jquery.tag-editor.min.js"></script>
<script src="js/plugin/moment.min.js"></script>
<script src="js/plugin/fullcalendar.min.js"></script>
<script src="js/plugin/locale-all.js"></script>
<script src="js/plugin/datepicker-zh-TW.js"></script>
<script src="js/plugin/jquery.timepicker.js"></script>

<script src="js/preview.js"></script>
<script src="js/calendar.js"></script>

@endsection