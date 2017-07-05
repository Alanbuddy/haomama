@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_course_new.css') }}">

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
            .desc-div.font-color3
              .text-message
                %form.form-inline
                  %label.input-caption.f16 课程名称:
                  %input.input-area.form-control#course-name{:type => "text"}
                .controls.controls-row
                  %label.input-caption.f16 课程类型:
                  %select.form-control.input-width#course-type
                    %option{value: "类型一"} 类型一
                    %option{value: "类型二"} 类型二
                    %option{value: "类型三"} 类型三
                  %label.input-caption.f16 课程节数:
                  %input.form-control.input-width{:type => "text"}
                .controls.controls-row
                  %label.input-caption.f16 课程价格:
                  %input.form-control.input-width#course-price{:type => "text"}
                  %label.input-caption.f16 促销价格:
                  %input.form-control.input-width{:type => "text"}
              .photo
                %a#upload-photo{href: "javascript:void(0);"}
                  %img.edit-photo#photo{src: "/icon/admin/photo-course.png"}
            .controls-div.font-color3
              .controls.controls-row
                %label.input-caption.f16 课程标签:
                // %input.input-area.form-control#tag-input
                %ul#type-tag
                
              .controls.controls-row
                %label.input-caption.course-length.f16 课次:
                %input.input-area.form-control#course-length{:type => "text"}
                %label.input-caption.f16 市场价:
                %input.input-area.form-control#course-price{:type => "text"}
                %label.input-caption.f16 公益价:
                %input.input-area.form-control#public-price{:type => "text"}
              .controls.controls-row
                %label.input-caption.f16 最小适龄:
                %input.input-area.form-control#min-age{:type => "text"}
                %label.input-caption.margin-l.f16 最大适龄:
                %input.input-area.form-control#max-age{:type => "text"}
                %label.input-caption.margin-l.f16 开课单位:
                // = select_tag "school_id", options_for_select(School.schools_for_select, @course_inst.try(:school_id)), class: "form-control input-area", :include_blank => "请选择开课单位"

              .course-introduce
                %span.introduce 课程介绍:
                %span.wangedit-area
                  #edit-area
              
              .calendar-wrapper.clearfix
                .calendar-operation-wrapper
                  %p.title 课程日历
                  %p.small-tips （单击日历中的时间进行删除）
                  .form-inline
                    %label.input-date 上课日期:
                    %input.input-area.form-control#datepicker{:type => "text"}
                  .form-inline
                    %label.input-date 开始时间:
                    %input.input-area.form-control#start-time{:type => "text"}
                  .form-inline
                    %label.input-date 结束时间:
                    %input.input-area.form-control#end-time{:type => "text"}
                  .btn#add-event{:type => "button"} 添加单次
                  .repeat.clearfix
                    .btn.date-btn{:type => "button"} 次日重复
                    .btn.week-btn{:type => "button"} 每周重复
                #calendar
@endsection

@section('script')
<script src= "{{mix('/js/admin_course_new.js')}}"></script>
@endsection