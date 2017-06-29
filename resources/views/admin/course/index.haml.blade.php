@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_c_index.css') }}">
@endsection

@section('content')
.content-area
  .main-top.direction
    .user-search-box.f14.bg2
      %input.input-style#search-input.font-color3{:type => "text", :placeholder => "输入课程名称、主讲人姓名", value: ""}
      .search#search-btn
    %ul.set
      %li
        %a.f16{href: "#"} 人员管理
        .dot
      %li
        %a.f16{href: "#"} 账号设置
      %li
        %a.f16.set-left-border{href: "#"} 退出登录
    // = render "staff/partials/account_set"
    
  .main-content.bg2
    %button.btn.new-normal.font-color1.btn-position#new-template{type: "button"} 新建课程模板
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 已开课程
          %li
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab2"} 课程模板

        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div
              // - if @course_insts[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: asset_path("undiscover.png")}
              // - else
              //   .table-box.f14
              //     %table.table.table-hover.table-height
              //       %thead.th-bg.font-color2
              //         %tr
              //           %th 课程名称
              //           %th 上课时间
              //           %th 上课地址
              //           %th 主讲人
              //           %th 价&nbsp格
              //           %th 操&nbsp作
              //       %tbody.font-color3
              //         - @course_insts[:data].each do |ci|
              //           %tr{class: "", "data-id" => ci[:id]}
              //             %td= link_to ci[:name], "/staff/courses/#{ci[:id]}"
              //             %td= ci[:date]
              //             %td= ci[:address]
              //             %td= ci[:speaker]
              //             %td= ci[:price]
              //             - if Date.parse(ci[:end_date]).past?
              //               %td.font-color4 已结课
              //             -else
              //               %td
              //                 - if ci[:available]
              //                   %a.set-available.font-color-red{href: "#"} 下架
              //                 - else
              //                   %a.set-available.font-color-green{href: "#"} 上架
              //   = render "staff/partials/auto_paginate", locals: { instance: @course_insts, url: "/staff/courses?keyword=#{@keyword}&", page: 'course_inst_page'}
                / .select-page 
                /   %span.totalitems= "共#{@course_insts[:total_page]}页，总计#{@course_insts[:total_number]}条"
                /   %span.choice-page
                /     %ul.pagination.pagination-sm
                /       %li
                /         %a{href: "/staff/courses?keyword=#{@keyword}&course_inst_page=#{@course_insts[:previous_page]}"} «
                /       - ( (@course_insts[:previous_page] > 2 ? @course_insts[:previous_page] - 2 : 1) .. (@course_insts[:next_page] < @course_insts[:total_page] - 2 ? @course_insts[:next_page] + 2 : @course_insts[:total_page]) ).to_a.each do |page|
                /         %li
                /           %a{href: "/staff/courses?keyword=#{@keyword}&course_inst_page=#{page}"}= page
                /       %li
                /         %a{href: "/staff/courses?keyword=#{@keyword}&course_inst_page=#{@course_insts[:next_page]}"} »
          #tab2.tab-pane
            .desc-div
              // - if @courses[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: asset_path("undiscover.png")}
              // - else
              //   .table-box.f14
              //     %table.table.table-hover.table-height
              //       %thead.th-bg.font-color2
              //         %tr
              //           %th 课程名称
              //           %th 课程编号
              //           %th 主讲人
              //           %th 价&nbsp格
              //           %th 操&nbsp作
              //       %tbody.font-color3
              //         - @courses[:data].each do |e|
              //           %tr
              //             %td= link_to e[:name], "/staff/courses/" + e[:id] + "/show_template"
              //             %td= e[:code]
              //             %td= e[:speaker]
              //             %td= e[:price]
              //             %td= link_to "开设课程", "/staff/courses/" + e[:id] + "/edit", class: "font-color-green" 
              //   = render "staff/partials/auto_paginate", locals: { instance: @courses, url: "/staff/courses?keyword=#{@keyword}&profile=template", page: 'course_page'}

                / .select-page 
                /   %span.totalitems= "共#{@courses[:total_page]}页，总计#{@courses[:total_number]}条"
                /   %span.choice-page
                /     %ul.pagination.pagination-sm
                /       %li
                /         %a{href: "/staff/courses?keyword=#{@keyword}&course_page=#{@courses[:previous_page]}&profile=template"} «
                /       - ( (@courses[:previous_page] > 2 ? @courses[:previous_page] - 2 : 1) .. (@courses[:next_page] < @courses[:total_page] - 2 ? @courses[:next_page] + 2 : @courses[:total_page]) ).to_a.each do |page|
                /         %li
                /           %a{href: "/staff/courses?keyword=#{@keyword}&course_page=#{page}&profile=template"}= page
                /       %li
                /         %a{href: "/staff/courses?keyword=#{@keyword}&course_page=#{@courses[:next_page]}&profile=template"} »
@endsection

@section('script')
<script src= "{{mix('/js/admin_c_index.js')}}"></script>
@endsection