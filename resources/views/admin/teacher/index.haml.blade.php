@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_teacher_index.css') }}">

:javascript
    window.lesson_index = "#{route('lessons.index')}"
    window.lesson_store = "#{route('lessons.store')}"
    window.video = "#{route('videos.store')}"
    window.token = "#{csrf_token()}"
    window.teacher_new = "#{route('users.create')}"

@endsection

@section('content')
.content-area
  .main-top.direction
    .user-search-box.f14.bg2
      %input.input-style#search-input.font-color3{:type => "text", :placeholder => "请输入讲师姓名、手机号", value: ""}
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
    %button.btn.new-normal.font-color1.btn-position#new-client{type: "button", "data-target" => "#kidsaddModal", "data-toggle" => "modal"} 添加讲师
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 所有讲师
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
                      %th 讲师姓名
                      %th 手机号
                      %th 职称
                  %tbody.font-color3
                    // - @users[:data].each do |u|
                    %tr
                      %td.teacher-show 张老师
                      %td 132344324535
                      %td xx医院xx科室主治医师
                    - foreach ($items as $item)
                    %tr
                      %td
                        %a{href: route('admin.user.show',$item->id).'?type=teacher'}=$item->name
                      %td=$item->phone
                      %td=json_decode($item->description)->title
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
<script src= "{{mix('/js/admin_teacher_index.js')}}"></script>
// <script src="/js/plugin/wangEditor.min.js"></script>
// <script src="/js/plugin/jquery-ui.min.js"></script>

// <script src="/js/fileupload.js"></script>

@endsection