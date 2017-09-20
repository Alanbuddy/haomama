@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/search_time.css') }}">

@endsection

@section('content')
    
.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li
          %a.f16.font-color1#current-data{href: route('statistics.index')} 当前数据
        %li.active
          %a.f16.font-color1#client 用户统计
        %li
          %a.f16.font-color1#amount{href: route('orders.statistics')} 金额统计
        %li
          %a.f16.font-color1#course-statistics{href: route('courses.statistics')} 课程统计
      .tab-content.bg3
        #tab2.tab-pane.active
          .desc-div
            .title-div
              %span.active.f16.font-color1 新用户
              %span.f16.font-color1 活跃用户
              %span.f16.font-color1 关注用户
              %span.f16.font-color1 总用户
            .figure-div{style: "display: block"}
              #new-statistics
              %span.new-statistics{style: "display: none;"}
            .figure-div
              #active-statistics
              %span.active-statistics{style: "display: none;"}
            .figure-div
              #focus-statistics
              %span.focus-statistics{style: "display: none;"}
            .figure-div
              #all-statistics
              %span.all-statistics{style: "display: none;"}
            .table-box
              %table.table.table-hover.table-height.f14
                %thead.th-bg.font-color2
                  %tr
                    %th 日期
                    %th 新用户
                    %th 活跃用户
                    %th 关注用户
                    %th 总用户
                %tbody.font-color3
                  -foreach($items as $item)
                    %tr
                      %td=$item->date
                      %td=$item->registration
                      %td=$item->activeUser
                      %td=$item->subscribe
                      %td=$item->total

            .select-page
              // %span.download.f14.fl 下载表格
              %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
              %span.choice-page
                != $items->links()

@endsection

@section('script')
<script src="js/plugin/jquery-ui.min.js"></script>
<script src= "js/plugin/highcharts.js"></script>
<script src= "js/client_statistics.js"></script>

@endsection