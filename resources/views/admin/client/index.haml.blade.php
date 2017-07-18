@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_client_index.css') }}">

:javascript
    window.lesson_index = "#{route('lessons.index')}"
    window.lesson_store = "#{route('lessons.store')}"
    window.video = "#{route('videos.store')}"
    window.token = "#{csrf_token()}"
  

@endsection

@section('content')
.content-area
  .main-top.direction
    .user-search-box.f14.bg2
      %input.input-style#search-input.font-color3{:type => "text", :placeholder => "请输入用户微信ID、微信名、手机号、宝宝姓名", value: ""}
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
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 关注用户(34343)
          %li
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab2"} 未关注用户(2345)
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div
              // - if @users[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
              // - else
              .table-box.f14
                %table.table.table-hover.table-height
                  %thead.th-bg.font-color2
                    %tr
                      %th 微信ID
                      %th 微信名
                      %th 手机号码
                      %th 家长身份
                      %th 宝宝姓名
                      %th 宝宝性别
                      %th 宝宝年龄
                  %tbody.font-color3
                    // - @users[:data].each do |u|
                    %tr
                      %td.client-show adfgafgafd132
                      %td 风中凌乱
                      %td 12324543546 
                      %td 妈妈 
                      %td 凉粉 
                      %td 女 
                      %td 3岁 
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
              // - if @users[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
              // - else
              .table-box.f14
                %table.table.table-hover.table-height
                  %thead.th-bg.font-color2
                    %tr
                      %th 微信ID
                      %th 微信名
                      %th 手机号码
                      %th 家长身份
                      %th 宝宝姓名
                      %th 宝宝性别
                      %th 宝宝年龄
                      %th 关注状态
                  %tbody.font-color3
                    // - @users[:data].each do |u|
                    %tr
                      %td.client-show adfgafgafd132
                      %td 风中凌乱
                      %td 12324543546 
                      %td 妈妈 
                      %td 凉粉 
                      %td 女 
                      %td 3岁  
                      %td 取消关注/或者未曾关注  
                      // %td 未曾关注  
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
<script src= "{{mix('/js/admin_client_index.js')}}"></script>
// <script src="/js/plugin/wangEditor.min.js"></script>
// <script src="/js/plugin/jquery-ui.min.js"></script>

// <script src="/js/fileupload.js"></script>

@endsection