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
          .desc-div.font-color3
            // - if(count($items) == 0)
            //   .undiscover.f14
            //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
            // - else
            .sign-box.clearfix
              .sign-method
                .class-choice
                  %label.f14.fn 课次选择
                  %select.select-style
                    %option 请选择课次
                    - foreach($lessons as $k=>$v)
                      %option{value: $k}="第".($k +1)."次课"
                .method
                  %p.caption 扫描签到
                  %p.scan-notice 请用微信右上角"扫描二维码"扫描~
                  #qr-code
                    %img.code-figure{src: "icon/admin/bigqrcode.png"}
                  .mask
                    %p.notice 该次课程已结束点击此处补签到
              .sign-status-box
                .sign-status
                  %h5 签到情况

@endsection


@section('script')
<script src="js/offline_signin.js"></script>

@endsection