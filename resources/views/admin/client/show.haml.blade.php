@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_client_show.css') }}">

@endsection

@section('content')
.content-area
  .main-top.direction
    %a{href: route('users.index')."?type=user"}
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
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 访问详情
          %li
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab2"} 课程购买
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div
              // - if @users[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "/icon/admin/undiscover.png"}
              // - else
              .table-box.f14
                %table.table.table-hover.table-height
                  %thead.th-bg.font-color2
                    %tr
                      %th 访问时间
                      %th 访问页面
                      %th 停留时间
                  %tbody.font-color3
                    // - @users[:data].each do |u|
                    %tr
                      %td 2017/06/26 22:12:06
                      %td 课程名称(第二课时)
                      %td 5 s/或者25 min
                    %tr
                      %td 2017/06/26 22:12:06
                      %td 课程名称(支付完成)
                      %td 5 s/25 min
                    %tr
                      %td 2017/06/26 22:12:06
                      %td 课程名称
                      %td 5 s/25 min
                    %tr
                      %td 2017/06/26 22:12:06
                      %td 搜索结果页(关键词：手工)
                      %td 5 s/25 min
                    %tr
                      %td 2017/06/26 22:12:06
                      %td 首页
                      %td 5 s/25 min
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
              // - if @participates[:data].blank?
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "/icon/admin/undiscover.png"}
              // - else
              .table-box.f14
                %table.table.table-hover.table-height.border-btm
                  %thead.th-bg.font-color2
                    %tr
                      %th 课程名称
                      %th 上课方式
                      %th 课程类型
                      %th 购买时间
                      %th 价格
                      %th 报名状态
                      %th 操&nbsp作
                  %tbody.font-color3
                    // - @participates[:data].each do |p|
                    %tr
                      %td 课程的名字很长
                      %td 线上视频/线下课程
                      %td 自我成长
                      %td 2017/06/26 22:12:06
                      %td 80
                      %td.font-color-brown 已付款
                      // %td 未付款
                      %td 
                        // - if p.is_success  
                        %a.details{:href => "javascript:void(0);"} 
                          上课情况
                          %span.triangle-down
                        // - else
                        //   .pay-fail 上课情况
                      // - if p.is_success
                    %tr.status
                      %td{colspan: "7"}
                        .course-status
                          %span.item-status 上课状态：
                          // - p.course_inst.length.times do |i|
                          //   - if p.signin_info[i].present?
                          %span.join-square
                            // - else
                            //   - if p.course_inst.is_class_pass?(i)
                          %span.miss-square
                            // - else
                          %span.square
                    %tr
                      %td 课程的名字很长
                      %td 线上视频/线下课程
                      %td 自我成长
                      %td 2017/06/26 22:12:06
                      %td 80
                      // %td.font-color-brown 已付款
                      %td 未付款
                      %td 
                        // - if p.is_success  
                        // %a.details{:href => "javascript:void(0);"} 
                        //   上课情况
                        //   %span.triangle-down
                        // - else
                        .pay-fail 上课情况
                      // - if p.is_success
              .tag2-foot.clearfix
                %span.num-div.font-color3.f16
                  %span 关注时间:
                  %span.mr30 2017/06/26 22:12:06

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
<script src= "{{mix('/js/admin_client_show.js')}}"></script>

@endsection