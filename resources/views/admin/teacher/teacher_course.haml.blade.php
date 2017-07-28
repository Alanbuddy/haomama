@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_teacher_show.css') }}">

:javascript
  window.teacher_index = "#{route('users.index')}"
  window.token = "#{csrf_token()}"
  window.teacher_update = "#{route('users.update',$user->id)}"
  window.teacher_show = "#{route('admin.user.show', -1)}"

@endsection

@section('content')
.content-area
  .main-top.direction
    %a{href: route('users.index')."?type=teacher"}
      %img.back{src: "icon/admin/back.png"}
    %ul.set
      %li
        %a.f16{href: route('users.index')."?type=operator"} 人员管理
        .dot
      %li
        %a.f16.left-border{href: route('admin.profile')} 账号设置
      %li
        %a.f16.set-left-border#exit{href: "javascript:void(0)"} 退出登录

  .main-content.bg2
    %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{type: "button"} 编辑
    %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 完成
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li
            %a.f16.font-color1 讲师详情
          %li.active
            %a.f16.font-color1#course 开设课程
        .tab-content.bg3
         
          #tab2.tab-pane.active
            .desc-div
              // - if @courses[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
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
<script src="js/plugin/wangEditor.min.js"></script>
<script src="js/teacher_preview.js"></script>
<script src="js/teacher_update.js"></script>

@endsection