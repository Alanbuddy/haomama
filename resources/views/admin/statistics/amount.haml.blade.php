@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/search_time.css') }}">
<link rel="stylesheet" href="css/plugin/jquery-ui.css">

@endsection

@section('content')
    
.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li
          %a.f16.font-color1#current-data{href: route('statistics.index')} 当前数据
        %li
          %a.f16.font-color1#client{href: route('statistics.user')} 用户统计
        %li.active
          %a.f16.font-color1#amount 金额统计
        %li
          %a.f16.font-color1#course-statistics{href: route('courses.statistics')} 课程统计
      .tab-content.bg3
        #tab3.tab-pane.active
          .desc-div
            // .title-div
            //   %span.active.f16.font-color1 新增收入
            //   %span.f16.font-color1 报名人数
            //   %span.f16.font-color1 付费人数
            //   %span.f16.font-color1 累计总收入
            // .figure-div{style: "display: block"}
            //   #new-statistics.new-comein
            // .figure-div
            //   #active-statistics.register
            // .figure-div
            //   #focus-statistics.pay-number
            // .figure-div
            //   #all-statistics.amount
            .table-box
              %table.table.table-hover.table-height.f14
                %thead.th-bg.font-color2
                  %tr
                    %th 日期
                    %th 新增收入(元)
                    %th 报名人数
                    %th 付费人数
                    %th 累计收入(元)
                %tbody.font-color3
                  %tr
                    %td 2017/06/12
                    %td 2110
                    %td 3650
                    %td 56770
                    %td 98759

            .select-page.clearfix
              // %span.download.f14.fl 下载表格
              // %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
              // %span.choice-page
              //   != $items->links()
            
            // .table-box
            //   %table.table.table-hover.table-height.f14
            //     %thead.th-bg.font-color2
            //       %tr
            //         %th 操作时间
            //         %th 微信ID
            //         %th 微信名
            //         %th 课程名称
            //         %th 金额(元)
            //     %tbody.font-color3
            //       %tr
            //         %td 2017/06/12
            //         %td afdsgfd
            //         %td 喵喵
            //         %td 课程的名字很长
            //         %td +80或者-20

            // .select-page.clearfix 
            //   %span.download.f14.fl 下载表格
            //   %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
            //   %span.choice-page
            //     != $items->links()
@endsection

@section('script')
<script src="js/plugin/jquery-ui.min.js"></script>
<script src="js/plugin/datepicker-zh-TW.js"></script>
<script src= "js/plugin/highcharts.js"></script>
<script src= "js/amount_statistics.js"></script>
@endsection