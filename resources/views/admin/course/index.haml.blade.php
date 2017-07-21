@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_c_index.css') }}">
:javascript
    window.course_index = "#{route('courses.index')}"
    window.course_create = "#{route('courses.create')}"
    window.logout = "#{route('logout')}"
    window.login = "#{route('login')}"
    window.token = "#{csrf_token()}"
@endsection

@section('content')
.content-area
  .main-top.direction
    .user-search-box.f14.bg2
      %input.input-style#search-input.font-color3{:type => "text", :placeholder => "输入课程名称、老师姓名", value: ""}
      .search#search-btn
    %ul.set
      %li
        %a.f16{href: route('users.index')} 人员管理
        .dot
      %li
        %a.f16.left-border{href: route('admin.profile')} 账号设置
      %li
        %a.f16.set-left-border#exit{href: "#"} 退出登录
    
  .main-content.bg2
    %button.btn.new-normal.font-color1.btn-position#new-template{type: "button"} 添加新课
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 当前课程(345)
          %li
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab2"} 未开课程(123)
          %li
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab3"} 结课课程(221)

        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div
              // - if @course_insts[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "/icon/admin/undiscover.png"}
              // - else
              .table-box
                %table.table.table-hover.table-height.f14
                  %thead.th-bg.font-color2
                    %tr
                      %th 课程名称
                      %th 上课方式
                      %th 课程类型
                      %th 授课老师
                      %th 当前价格
                      %th 推荐设置
                  %tbody.font-color3
                    // - @course_insts[:data].each do |ci|
                    %tr{class: ""}
                      // %td= link_to ci[:name], "/staff/courses/#{ci[:id]}"
                      %td.show-name 课程的名字
                      %td 线上视频or线下课程
                      %td 健康教育
                      %td 李老师、王老师
                      %td 80
                      %td 新课速递推荐、健康教育推荐
                    - foreach ($items as $course)
                      %tr
                        %td
                          %a{href: route('admin.courses.show',$course->id)}=$course->name
                        %td=$course->type
                        %td=$course->category->name
                        %td 李老师、王老师
                        %td=$course->price
                        %td

              .select-page 
                %span.totalitems 共2页，总计18条
                %span.choice-page
                  %ul.pagination.pagination-sm
                    %li
                      %a{href: "#"} «
                    %li
                      %a{href: "#"} 1
                    %li
                      %a{href: "#"} »
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
                      %th 课程名称
                      %th 上课方式
                      %th 课程类型
                      %th 授课老师
                      %th 当前价格
                      
                  %tbody.font-color3
                    %tr
                      %td 课程的名字很长
                      %td 线上视频
                      %td 自我成长
                      %td 李老师、王老师
                      %td 80

              .select-page 
                %span.totalitems 共2页，总计18条
                %span.choice-page
                  %ul.pagination.pagination-sm
                    %li
                      %a{href: "#"} «
                    %li
                      %a{href: "#"} 1
                    %li
                      %a{href: "#"} »
          #tab3.tab-pane
            .desc-div
              // - if @courses[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "/icon/admin/undiscover.png"}
              // - else
              .table-box
                %table.table.table-hover.table-height.f14
                  %thead.th-bg.font-color2
                    %tr
                      %th 课程名称
                      %th 上课方式
                      %th 课程类型
                      %th 授课老师
                      %th 当前价格
                      
                  %tbody.font-color3
                    %tr
                      %td 课程的名字很长
                      %td 线上视频
                      %td 自我成长
                      %td 李老师、王老师
                      %td 80

              .select-page 
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
#addModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/admin/delete1.png"}
      .modal-body
        .courses-div
          .item.course-video
            %img{src: "icon/admin/media.png"}
            %p 音/视频课程
          .item.offline
            %img{src: "icon/admin/class.png"}
            %p 线下课程
@section('script')
<script src= "{{mix('/js/admin_c_index.js')}}"></script>
<script src= "js/admin-add-course.js"></script>


@endsection