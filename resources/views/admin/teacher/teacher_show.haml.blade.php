@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_teacher_show.css') }}">

:javascript
  window.teacher_index = "#{route('users.index')}"
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
    %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{type: "button"} 编辑
    %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 完成
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 讲师详情
          %li
            %a.f16.font-color1#course{"data-toggle" => "tab", :href => "#tab2"} 开设课程(120)
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div.font-color3.clearfix.f14
              .text-message.mt15
                .controls.controls-row
                  %label.input-caption 讲师姓名:
                  %span.unedit-box.unedit-span 课程的名字很长
                  %span.edit-box
                    %input.form-control.input-width#teacher-name{:type => "text", placeholder: "必填"}
                  %label.input-caption#mobile-label 手机号:
                  %span.unedit-box.unedit-span 课程的名字很长
                  %span.edit-box
                    %input.form-control.input-width#mobile{:type => "text", placeholder: "必填"}
                .controls.controls-row.mt25#second-row
                  %label.input-caption#tencent-label QQ号:
                  %span.unedit-box.unedit-span 课程的名字很长
                  %span.edit-box
                    %input.form-control.input-width#tencent{:type => "text"}
                  %label.input-caption#Email-label 邮箱:
                  %span.unedit-box.unedit-span 课程的名字很长
                  %span.edit-box
                    %input.form-control.input-width#mail{:type => "text"}
              %input#previewImg{:onchange => "previewImage(this)", :type => "file", style: "display:none;"}
              .photo#preview
                %img.unedit-box.teacher-avatar{src: "/icon/teacher_avatar.png"}
                %img.edit-box.edit-photo#imghead{src: "/icon/admin/add3.png", onclick: "$('#previewImg').click()"}
                
            .controls-div.font-color3.f14
              .controls.controls-row
                %label.input-caption 讲师职称:
                %span.unedit-box.middle-span 课程的名字很长
                %span.edit-box
                  %input.input-area.form-control.middle#title{:type => "text"}
                %label.input-caption 座机:
                %span.unedit-box 课程的名字很长
                %span.edit-box
                  %input.form-control.input-width#tel{:type => "text"}
              .controls.controls-row
                %label.input-caption.double-label 专长:
                %span.unedit-box.middle-span 课程的名字很长
                %span.edit-box
                  %input.input-area.form-control.middle#prefer{:type => "text"}
                %label.input-caption 备注:
                %span.unedit-box 课程的名字很长
                %span.edit-box
                  %input.form-control.input-width#remark{:type => "text"}
              .controls.controls-row
                %label.input-caption.double-label.vt#reward-label 获奖:
                %span.unedit-box.longspan 课程的名字很长课程的名字很长课程的名字很长课程的名字很长课程的名字很长课程的名字很长课程的名字很长课程的名字很长课程的名字很长课程的名字很长
                %span.edit-box
                  %input.input-area.form-control.longinput#reward{:type => "text"}
              .controls.controls-row
                %label.input-caption.double-label.vt#book-label 出书:
                %span.unedit-box.longspan 课程的名字很长
                %span.edit-box
                  %input.input-area.form-control.longinput#book{:type => "text"}
              .controls.controls-row
                %label.input-caption 基础简介:
                %span.unedit-box 课程的名字很长
                %span.edit-box
                  %input.input-area.form-control.longinput#base{:type => "text", placeholder: "必填，显示在课程页中，限20字内"}
              .course-introduce.introduce-flex
                %span.introduce 讲师介绍:
                %span.unedit-box.longspan 该课程是少儿类视频第一名
                %span.edit-box.wangedit-area
                  #edit-area
                    %p 必填,限100字内
          #tab2.tab-pane
            .desc-div
              // - if @courses[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "/icon/admin/undiscover.png"}
              // - else
              .table-box
                %table.table.table-hover.table-height.f14
                  %thead.th-bg.font-color2
                    %tr
                      %th 课程名
                      %th 上课方式
                      %th 课程类型
                      %th 课程节数
                      %th 购买人数
                      %th 课程总收入
                      
                  %tbody.font-color3
                    %tr
                      %td 课程的名字很长
                      %td 线上视频
                      %td 健康养育
                      %td 12
                      %td 80
                      %td 3000
              .tag2-foot.clearfix
                %span.num-div.font-color3.f16
                  %span 总购买人次:
                  %span.mr30 123
                  %span 总课程收入:
                  %span 5555555

                %span.select-page.tag2-page
                  %span.totalitems 共2页，总计18条
                  %span.choice-page
                    %ul.pagination.pagination-sm
                      %li
                        %a{href: "#"} «
                      %li
                        %a{href: "#"} 1
                      %li
                        %a{href: "#"} »            
@endsection

@section('script')
<script src= "{{mix('/js/admin_teacher_show.js')}}"></script>
<script src="/js/plugin/wangEditor.min.js"></script>
<script src="/js/teacher_preview.js"></script>

@endsection