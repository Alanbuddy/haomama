@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_teacher_show.css') }}">
:javascript
  window.teacher_index = "#{route('users.index')."?type=teacher"}"
  window.token = "#{csrf_token()}"
  window.teacher_update = "#{route('users.update',$user->id)}"
  window.teacher_show = "#{route('admin.user.show', -1)}"
  window.teacher_course = "#{route('admin.teacher.course', -1)}"
  window.teacher_del = "#{route('users.destroy',$user->id)}"

@endsection
@section('search-input')
%a{href: route('users.index')."?type=teacher"}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')

.main-content.bg2
  - if(count($courses)== 0)
    %button.btn.delete-normal.font-color1.delete-btn-position#delete-btn{type: "button"} 删除
  %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{type: "button"} 编辑
  %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 完成
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li.active
          %a.f16.font-color1#teacher-desc 讲师详情
        %li
          %a.f16.font-color1#course 开设课程
      .tab-content.bg3
        #tab1.tab-pane.active
          .desc-div.font-color3.clearfix.f14
            .text-message.mt15
              .controls.controls-row
                %label.input-caption 讲师姓名:
                %span.unedit-box.unedit-span#name-span= $user->name
                %span.teacher-id{style: "display: none;"}= $user->id
                %span.edit-box
                  %input.form-control.input-width#teacher-name{:type => "text", placeholder: "必填"}
                %label.input-caption#mobile-label 手机号:
                %span.unedit-box.unedit-span#mobile-span= $user->phone
                %span.edit-box
                  %input.form-control.input-width#mobile{:type => "text", placeholder: "必填"}
              .controls.controls-row.mt25#second-row
                %label.input-caption#tencent-label QQ号:
                %span.unedit-box.unedit-span#tencent-span= $user->description->qq
                %span.edit-box
                  %input.form-control.input-width#tencent{:type => "text"}
                %label.input-caption#Email-label 邮箱:
                %span.unedit-box.unedit-span#mail-span= $user->email
                %span.edit-box
                  %input.form-control.input-width#mail{:type => "text"}
            %input#previewImg{:onchange => "previewImage(this)", :type => "file", style: "display:none;"}
            .photo#preview
              %img.unedit-box.teacher-avatar{src: $user->avatar ? strpos($user->avatar, '/')==0?substr($user->avatar,1):$user->avatar : "icon/teacher_avatar.png"}
              %img.edit-box.edit-photo#imghead{src: $user->avatar ? strpos($user->avatar, '/')==0?substr($user->avatar,1):$user->avatar : "icon/admin/add3.png", onclick: "$('#previewImg').click()"}
            %span.cover-path{style: "display:none;"}= $user->avatar ? strpos($user->avatar, '/')==0?substr($user->avatar,1):$user->avatar : "icon/teacher_avatar.png"
              
          .controls-div.font-color3.f14
            .controls.controls-row
              %label.input-caption 讲师职称:
              %span.unedit-box.middle-span#title-span= $user->description->title
              %span.edit-box
                %input.input-area.form-control.middle#title{:type => "text"}
              %label.input-caption 座机:
              %span.unedit-box#tel-span= $user->description->telephone
              %span.edit-box
                %input.form-control.input-width#tel{:type => "text"}
            .controls.controls-row
              %label.input-caption.double-label 专长:
              %span.unedit-box.middle-span#major-span= $user->description->major
              %span.edit-box
                %input.input-area.form-control.middle#major{:type => "text"}
              %label.input-caption 备注:
              %span.unedit-box#remark-span= $user->description->remark
              %span.edit-box
                %input.form-control.input-width#remark{:type => "text"}
            .controls.controls-row
              %label.input-caption.double-label.vt#reward-label 获奖:
              %span.unedit-box.longspan#reward-span= $user->description->award
              %span.edit-box
                %input.input-area.form-control.longinput#reward{:type => "text"}
            .controls.controls-row
              %label.input-caption.double-label.vt#book-label 出书:
              %span.unedit-box.longspan#book-span= $user->description->book
              %span.edit-box
                %input.input-area.form-control.longinput#book{:type => "text"}
            .controls.controls-row
              %label.input-caption 基础简介:
              %span.unedit-box#base-span= $user->description->basicIntroduction
              %span.edit-box
                %input.input-area.form-control.longinput#base{:type => "text", placeholder: "必填，显示在课程页中，限20字内"}
            .course-introduce.introduce-flex
              %span.introduce 讲师介绍:
              %span.unedit-box.longspan#desc-span!= $user->description->introduction
              %span#desc-html{style: "display:none;"}= $user->description->introduction
              %span.edit-box.wangedit-area
                #edit-area
                
@endsection

@section('script')
<script src="js/plugin/wangEditor.min.js"></script>
<script src="js/teacher_preview.js"></script>
<script src="js/teacher_update.js"></script>

@endsection