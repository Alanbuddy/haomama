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
    %a{href: staff_courses_path}
      %img.back{src: asset_path("back.png")}
    %ul.set
      %li
        %a.f16{href: "#"} 人员管理
        .dot
      %li
        %a.f16{href: "#"} 账号设置
      %li
        %a.f16.set-left-border{href: "#"} 退出登录

  .main-content.bg2
    %button.btn.new-normal.font-color1.btn-position#open-now{type: "button"} 立即开课
    %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 完成
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 模板详情
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div.font-color3
              .text-message
                %form.form-inline
                  %label.input-caption 课程名称:
                  %input.input-area.form-control#course-name{:type => "text"}
                .form-group
                  %label.input-caption 上课时间:
                  %input.input-area.form-control#course-date{:type => "text"}
                .form-group
                  %label.input-caption 上课地址:
                  %input.input-area.form-control#course-address{:type => "text"}
              .photo
                // = form_tag("/", method: "post", multipart: true, id: "upload-photo-form", class: "hide") do
                //   = file_field_tag "photo_file", { class: "hide", accept: ".jpg,.png" }
                // %a#upload-photo{href: "javascript:void(0);"}
                //   %img.edit-photo#photo{:src => @course_inst.try(:photo).nil? ? asset_path("web/photo.png") : @course_inst.photo.path}

            .controls.controls-row
              %label.input-caption 开课编号:
              %span.num-box
              %label.input-caption 主讲人:
              %input.input-area.form-control#course-speaker{:type => "text"}
              %label.input-caption.kids-capacity 容量:
              %input.input-area.form-control#course-capacity{:type => "text"}
            .controls.controls-row
              %label.input-caption.course-length 课次:
              %input.input-area.form-control#course-length{:type => "text"}
              %label.input-caption 市场价:
              %input.input-area.form-control#course-price{:type => "text"}
              %label.input-caption 公益价:
              %input.input-area.form-control#public-price{:type => "text"}
            .controls.controls-row
              %label.input-caption 最小适龄:
              %input.input-area.form-control#min-age{:type => "text"}
              %label.input-caption.margin-l 最大适龄:
              %input.input-area.form-control#max-age{:type => "text"}
              %label.input-caption.margin-l 开课单位:
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