@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/offline_show.css') }}">

:javascript
  window.course_index = "#{route('courses.index')}"
  window.course_publish = "#{route('courses.publish',$course->id)}"
  window.course_show = "#{route('admin.courses.show',$course->id)}"
  window.token = "#{csrf_token()}"
  window.offline_student = "#{route('admin.courses.students',$course->id)}"

@endsection
@section('search-input')
%a{href: route('courses.index')}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')

.main-content.bg2
  %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{:type => "button", "data-target" => "#noticeModal", "data-toggle" => "modal"} 编辑通知
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li
          %a.f16.font-color1#course-show 课程详情
        %li
          %a.f16.font-color1#register 报名信息
        %li.active
          %a.f16.font-color1#sign 课程签到
      .tab-content.bg3
        #tab3.tab-pane.active
          .desc-div
            // - if(count($items) == 0)
            //   .undiscover.f14
            //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
            // - else
            .sign-box.clearfix
              .sign-method
                .class-choice
                  %form.form-horizontal
                    .form-group
                      %label.col-sm-5.col-md-3.control-label{:for => "class"} 课次选择
                      %input.col-sm-6.col-md-6
                      
                .method
                  %p.caption 签到方式一：扫描签到
                  #qr-code
                    %img.code-figure{src: asset_path("web/bigqrcode.png")}
                  .mask
                    %p.notice 该次课程已结束点击此处补签到
              .sign-status-box
                .sign-status
                  %h5 签到情况

@endsection


@section('script')
<script src="js/offline_signin.js"></script>

@endsection