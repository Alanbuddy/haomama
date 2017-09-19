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
          %a.f16.font-color1#course 课程统计
      .tab-content.bg3
        #tab1.tab-pane.active
          .desc-div
            .courses-income-box.border-btm
              %p.amount.font-color3.f16 昨日金额数据
              .amount-div
                .amount-items
                  %p.amount-caption.font-color3.f16 新增收入(元)
                  %p.amount-nums 10000
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                .amount-items
                  %p.amount-caption.font-color3.f16 报名人数
                  %p.amount-nums 6000
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                .amount-items#goverment
                  %p.amount-caption.font-color3.f16 付费人数
                  %p.amount-nums 4000
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                .amount-items
                  %p.amount-caption.font-color3.f16 累计总收入(元)
                  %p.amount-nums 10000
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
            .courses-income-box.border-btm
              %p.amount.font-color3.f16 昨日用户数据
              .amount-div
                .amount-items
                  %p.amount-caption.font-color3.f16 新用户
                  %p.amount-nums 10000
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                .amount-items
                  %p.amount-caption.font-color3.f16 活跃用户
                  %p.amount-nums 6000
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                .amount-items#goverment
                  %p.amount-caption.font-color3.f16 关注用户
                  %p.amount-nums 4000
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                .amount-items
                  %p.amount-caption.font-color3.f16 总用户
                  %p.amount-nums 10000
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space 13.1%
@endsection

@section('script')

@endsection