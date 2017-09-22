@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_statistics_index.css') }}">

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
        %li
          %a.f16.font-color1#amount{href: route('orders.statistics')} 金额统计
        %li.active
          %a.f16.font-color1#course-statistics 课程统计
      .tab-content.bg3
        #tab4.tab-pane.active
          .desc-div
            .table-box
              %table.table.table-hover.table-height.f14
                %thead.th-bg.font-color2
                  %tr
                    %th 课程名
                    %th 上线时间
                    %th 累计收入
                    %th 付费收入
                    %th 报名人数
                    %th 付费人数
                    %th 分享人数
                    %th 收藏人数
                %tbody.font-color3
                -foreach($items as $item)
                  %tr
                    %td=$item['name']
                    %td=$item['updated_at']
                    %td=$item['total_fee']
                    %td=$item['total_fee']
                    %td=$item['users_count']
                    %td=$item['orders_count']
                    %td=$item['share_records_count']
                    %td=$item['followers_count']

            .select-page.clearfix 
              // %span.download.f14.fl 下载表格
              %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
              %span.choice-page
              != $items->links()
@endsection

@section('script')

@endsection