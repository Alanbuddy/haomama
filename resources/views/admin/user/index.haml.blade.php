@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/user-index.css') }}">
:javascript
    // window.course_index = "#{route('courses.index')}"
    // window.course_create = "#{route('courses.create')}"
    // window.logout = "#{route('logout')}"
    // window.login = "#{route('login')}"
    // window.token = "#{csrf_token()}"
@endsection

@section('content')
.content-area
  .main-top.direction
    %ul.set
      %li
        %a.f16{href: route('users.index')} 人员管理
        .dot
      %li
        %a.f16.left-border{href: route('admin.profile')} 账号设置
      %li
        %a.f16.set-left-border#exit{href: "#"} 退出登录
  .main-content.bg2
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 人员管理
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div
              // - if @staffs[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
              // - else
              .table-box.f14
                %table.table.table-hover.table-height#admin
                  %thead.th-bg.font-color2
                    %tr
                      %th 手机号
                      %th 姓&nbsp&nbsp名
                      %th 状&nbsp&nbsp态
                      %th{colspan: "2"} 操&nbsp&nbsp作
                  %tbody.font-color3
                    // - @staffs[:data].each do |s|
                    %tr
                      %td 1312234434343
                      %td dadga/没有名字时显示“-” 
                      %td 新注册账号/正常/关闭
                      %td
                        // %a.change_status.available.font-color-brown{:href => "javascript:void(0);"} 关闭
                        %a.change_status.unavailable.font-color-green{:href => "javascript:void(0);"} 开通
                      %td
                        %a.font-color-red{href: "#"} 删除
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

@section('script')
<script src= "js/admin-user-index.js"></script>


@endsection