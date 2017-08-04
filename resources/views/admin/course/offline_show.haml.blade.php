@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/offline_show.css') }}">
<link rel="stylesheet" href="css/plugin/jquery-ui.css">
<link href="css/plugin/jquery.tag-editor.css" rel="stylesheet" type="text/css">
<link href="css/plugin/fullcalendar.min.css" rel="stylesheet" type="text/css">
<link href="css/plugin/jquery.timepicker.css" rel="stylesheet" type="text/css">


:javascript
  window.course_index = "#{route('courses.index')}"
  window.course_update = "#{route('courses.update', $course->id)}"
  window.token = "#{csrf_token()}"
  window.add_teacher = "#{route('users.search')}"
  window.tag_store = "#{route('terms.store')}"
  window.tag_destroy = "#{route('terms.destroy',-1)}"
  window.lessons_index = "#{route('lessons.index')}"
  window.course_publish = "#{route('courses.publish',$course->id)}"
  window.course_show = "#{route('admin.courses.show',$course->id)}"

@endsection
@section('search-input')
%a{href: route('courses.index')}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')

.main-content.bg2
  - if(auth()->user()->hasRole('admin'))
    - if($course->status == "draft")
      %button.btn.delete-normal.font-color1.unshelve-btn-position#unshelve-btn.operation{type: "button"} 上线课程
    - else
      %button.btn.delete-normal.font-color1.unshelve-btn-position#shelve-btn.operation{type: "button"} 下架课程
  %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{type: "button"} 编辑
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
              .controls.controls-row.margin20.mt30#name-control
                %label.input-caption 课程名称:
                %span.unedit-box#name-span= $course->name
                %span.edit-box
                  %input.input-area.form-control#course-name{:type => "text", placeholder: "必填"}
              .controls.controls-row
                %label.input-caption 课程类型:
                %span.unedit-box.short-span#type-span{"data-type-id"=> $course->category->id}=$course->category->name
                %span.edit-box
                  %select.form-control.input-width#course-type
                    %option 请选择类型
                    - foreach ($categories as $category )
                      %option{value: $category->id}= $category->name
                %label.input-caption 课程节数:
                %span.unedit-box#length-span= count(json_decode($course->titles))
                %span.edit-box
                  %input.form-control.input-width#course-length{:type => "text"}
              .controls.controls-row
                %label.input-caption 课程价格:
                %span.unedit-box.short-span#original-span= $course->original_price
                %span.edit-box
                  %input.form-control.input-width#course-price{:type => "text"}
                %label.input-caption 促销价格:
                %span.unedit-box.font-color-red#price-span= $course->price ? $course->price : "无"
                %span.edit-box
                  %input.form-control.input-width#pay-price{:type => "text"}
            %input#previewImg{:onchange => "previewImage(this)", :type => "file", style: "display:none;"}
            .photo#preview
              %img.unedit-box.unedit-photo{src: $course->cover ? $course->cover : "icon/admin/photo-course.png"}
              %img.edit-box.edit-photo#imghead{src: $course->cover ? $course->cover : "icon/admin/photo-course.png", onclick: "$('#previewImg').click()"}
            %span.cover-path{style: "display:none;"}= $course->cover ? $course->cover : "icon/admin/photo-course.png"

          .controls-div.font-color3.f14
            .controls.controls-row
              %label.input-caption 上课时间:
              %span.unedit-box.mid-span#date-span= $course->time
              %span.edit-box
                %input.form-control.input-width#lesson-date{:type => "text"}
              %label.input-caption 最少人数:
              %span.unedit-box#min-span= $course->minimum
              %span.edit-box
                %input.form-control.input-width#min-num{:type => "text"}
            .controls.controls-row
              %label.input-caption 上课地点:
              %span.unedit-box.mid-span#address-span= $course->address
              %span.edit-box
                %input.form-control.input-width#lesson-address{:type => "text"}
              %label.input-caption 最多人数:
              %span.unedit-box#max-span= $course->quota
              %span.edit-box
                %input.form-control.input-width#max-num{:type => "text"}
            .controls.controls-row.tag-flex#edit-tag
              %label.input-caption 课程标签:
              %span.unedit-box.ml4
                - foreach($course->tags as $tag)
                  %span.tag-span{"data-id" => $tag->id}= $tag->name
              %span.edit-box.tag-div
                #type-tag
            .hot-tag-div.edit-box
              - foreach($popularTags as $tag)
                %span{value: $tag->id}= $tag->name
            .create-tag-div{style: "display:none"}

            .controls.controls-row.no-mb.tag-flex
              %label.input-caption.teacher-tag 授课老师:
              %span.unedit-box.ml4
                -foreach($course->teachers as $teacher)
                  %span.teacher-tag-span=$teacher->name
              %span.edit-box.teacher-edit-box
                - foreach($course->teachers as $teacher)
                  %span.add-tag
                    %span.teacher-name= $teacher->name
                    %span.teacher-id= $teacher->id
                    %img.delete-tag{src: "icon/admin/delete.png"}
            .edit-box.teacher-div
              %input#teacher{type: "text"}

            .calendar-wrapper.clearfix
              .show-calendar#calendar
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
            .date-div{style: "display:none;"}
              - if($course->schedule)
                - foreach(json_decode($course->schedule) as $date)
                  %span= $date
              
            .course-introduce.introduce-flex
              %span.introduce 课程介绍:
              %span.unedit-box#desc-span.ml4!= $course->description
              %span#desc-html{style: "display:none;"}= $course->description
              %span.edit-box.wangedit-area
                #edit-area
            .lesson-div.introduce-flex
              %span.introduce 课时标题:
              .unedit-box.ml4#unedit-title
                - if ($course->titles)
                  - foreach(json_decode($course->titles) as $title)
                    %p.title-desc= $title
#shelfModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/admin/close.png"}
      .modal-body
        - if($course->status == "draft")
          %p.message 是否确认上线当前课程？
        - else
          %p.message 是否确认下架当前课程？
        .btn-div
          %button.btn#shelf-cancel{type: "button"} 取&nbsp消
          %button.btn#shelf-confirm{type: "button"} 确&nbsp定                
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
<script src="js/admin_offline_show.js"></script>


@endsection