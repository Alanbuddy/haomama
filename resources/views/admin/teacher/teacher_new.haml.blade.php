@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_teacher_new.css') }}">

:javascript
  window.teacher_index = "#{route('users.index')}"
  window.teacher_store = "#{route('users.store')}"
  window.teacher_show = "#{route('users.show', -1)}"
  window.token = "#{csrf_token()}"
@endsection

@section('content')
.content-area
  .main-top.direction
    %a{href: route('users.index')."?type=teacher"}
      %img.back{src: "/icon/admin/back.png"}
    %ul.set
      %li
        %a.f16{href: route('users.index')} 人员管理
        .dot
      %li
        %a.f16.left-border{href: route('admin.profile')} 账号设置
      %li
        %a.f16.set-left-border#exit{href: "#"} 退出登录

  .main-content.bg2
    %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 完成
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 添加讲师
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div.font-color3.clearfix.f14
              .text-message
                .controls.controls-row
                  %label.input-caption 讲师姓名:
                  %input.form-control.input-width#teacher-name{:type => "text", placeholder: "必填"}
                  %label.input-caption#mobile-label 手机号:
                  %input.form-control.input-width#mobile{:type => "text", placeholder: "必填"}
                .controls.controls-row
                  %label.input-caption#tencent-label QQ号:
                  %input.form-control.input-width#tencent{:type => "text"}
                  %label.input-caption#Email-label 邮箱:
                  %input.form-control.input-width#mail{:type => "text"}
              %input#previewImg{:onchange => "previewImage(this)", :type => "file", style: "display:none;"}
              .photo#preview
                %img.edit-photo#imghead{src: "/icon/admin/add3.png", onclick: "$('#previewImg').click()"}
              %span.cover-path{style: "display:none;"}
                
            .controls-div.font-color3.f14
              .controls.controls-row
                %label.input-caption 讲师职称:
                %input.input-area.form-control.middle#title{:type => "text"}
                %label.input-caption 座机:
                %input.form-control.input-width#tel{:type => "text"}
              .controls.controls-row
                %label.input-caption.double-label 专长:
                %input.input-area.form-control.middle#major{:type => "text"}
                %label.input-caption 备注:
                %input.form-control.input-width#remark{:type => "text"}
              .controls.controls-row
                %label.input-caption.double-label 获奖:
                %input.input-area.form-control.longinput#award{:type => "text"}
              .controls.controls-row
                %label.input-caption.double-label 出书:
                %input.input-area.form-control.longinput#book{:type => "text"}
              .controls.controls-row
                %label.input-caption 基础简介:
                %input.input-area.form-control.longinput#base{:type => "text", placeholder: "必填，显示在课程页中，限20字内", maxlength:20}
              .course-introduce
                %span.introduce 讲师介绍:
                %span.wangedit-area
                  #edit-area
                    %p 必填,限100字内
              
@endsection

@section('script')
<script src="js/plugin/wangEditor.min.js"></script>
<script src="js/teacher_preview.js"></script>
<script src="js/admin_teacher_create.js"></script>

@endsection
