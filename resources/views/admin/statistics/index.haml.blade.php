@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_statistics_index.css') }}">
   
@endsection

@section('content')
    
.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li.active
          %a.f16.font-color1#current-data 当前数据
        %li
          %a.f16.font-color1#client{href: route('statistics.user')} 用户统计
        %li
          %a.f16.font-color1#amount{href: route('orders.statistics')} 金额统计
        %li
          %a.f16.font-color1#course-statistics{href: route('courses.statistics')} 课程统计
      .tab-content.bg3
        #tab1.tab-pane.active
          .desc-div
            .courses-income-box.border-btm
              %p.amount.font-color3.f16 昨日金额数据
              .amount-div
                .amount-items
                  %p.amount-caption.font-color3.f16 新增收入(元)
                  %p.amount-nums= $deltaIncomeStat['incomeOfLastDay']
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space=round($deltaIncomeStat['compareDay']*100).'%'
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space=round($deltaIncomeStat['compareWeek']*100).'%'
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space=round($deltaIncomeStat['compareMonth']*100).'%'
                .amount-items
                  %p.amount-caption.font-color3.f16 报名人数
                  %p.amount-nums=$orderStat['ordersOfLastDay']
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space=round($orderStat['compareDay']*100).'%'
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space =round($orderStat['compareWeek']*100).'%'
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space =round($orderStat['compareMonth']*100).'%'
                .amount-items#goverment
                  %p.amount-caption.font-color3.f16 付费人数
                  %p.amount-nums =$orderStat['ordersOfLastDay']
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space =round($orderStat['compareDay']*100).'%'
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space =round($orderStat['compareWeek']*100).'%'
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space =round($orderStat['compareMonth']*100).'%'
                .amount-items
                  %p.amount-caption.font-color3.f16 累计总收入(元)
                  %p.amount-nums =$incomeStat['income']
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space =round($incomeStat['compareDay']*100).'%'
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space =round($incomeStat['compareWeek']*100).'%'
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space =round($incomeStat['compareMonth']*100).'%'
            .courses-income-box.border-btm
              %p.amount.font-color3.f16 昨日用户数据
              .amount-div
                .amount-items
                  %p.amount-caption.font-color3.f16 新用户
                  %p.amount-nums =$registrationStat['registrationsOfLastDay']
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space =round($registrationStat['compareDay']*100).'%'
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space=round($registrationStat['compareWeek']*100).'%'
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space =round($registrationStat['compareMonth']*100).'%'
                .amount-items
                  %p.amount-caption.font-color3.f16 活跃用户
                  %p.amount-nums =$activeUserStat['activeUsersOfLastDay']
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space =round($activeUserStat['compareDay']*100).'%'
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space =round($activeUserStat['compareWeek']*100).'%'
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space =round($activeUserStat['compareMonth']*100).'%'
                .amount-items#goverment
                  %p.amount-caption.font-color3.f16 关注用户
                  %p.amount-nums=$subscriberStat['subscribersOfLastDay']
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space=round($subscriberStat['compareDay']*100).'%'
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space=round($subscriberStat['compareWeek']*100).'%'
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space=round($subscriberStat['compareMonth']*100).'%'
                .amount-items
                  %p.amount-caption.font-color3.f16 总用户
                  %p.amount-nums=$usersCountStat['usersCount']
                  .font-color3.f14
                    %span 日
                    %img{src: "icon/admin/arrow_down.png"}
                    %span.span-space=round($usersCountStat['compareDay']*100).'%'
                  .font-color3.f14
                    %span 周
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space =round($usersCountStat['compareWeek']*100).'%'
                  .font-color3.f14
                    %span 月
                    %img{src: "icon/admin/arrow_up.png"}
                    %span.span-space =round($usersCountStat['compareMonth']*100).'%'
@endsection

@section('script')

@endsection