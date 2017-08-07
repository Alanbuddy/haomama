@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/offline_show.css') }}">

:javascript
  window.course_index = "#{route('courses.index')}"
  window.course_publish = "#{route('courses.publish',$course->id)}"
  window.course_show = "#{route('admin.courses.show',$course->id)}"
  window.token = "#{csrf_token()}"

@endsection
@section('search-input')
%a{href: route('courses.index')}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')

.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li
          %a.f16.font-color1#course-show 课程详情
        %li.active
          %a.f16.font-color1#register 报名信息
        %li
          %a.f16.font-color1#sign 课程签到
      .tab-content.bg3
        #tab2.tab-pane.active
          .desc-div
            - if(count($items) == 0)
              .undiscover.f14
                %img.undiscover-icon{src: "icon/admin/undiscover.png"}
            - else
              .table-box
                %table.table.table-hover.table-height.f14
                  %thead.th-bg.font-color2
                    %tr
                      %th 微信ID
                      %th 微信名
                      %th 手机号
                      %th 购买时间
                      %th 价格
                      %th 报名状态
                      %th 操作
                  %tbody.font-color3
                    - foreach($items as $item)
                      %tr
                        %td= $item->openid
                        %td= $item->wx ? json_decode($item->wx)->nickname : "无"
                        %td= $item->phone
                        %td= $item->order ? $item->order->created_at : "无"
                        %td= $item->order ? $item->order->wx_total_fee : "无"
                        - if(empty($item->order))
                          %td 未付款
                        - else if( $item->order->status == "paid")
                          %td.font-color-brown 已付款

                      %tr.status
                        %td{:colspan => "7"}
                          .course-status
                            %span.item-status 上课状态：
                            %span.join-square
                            %span.miss-square
                            %span.square
              .tag2-foot.clearfix
                %span.num-div.font-color3.f16
                  %span 总购买人数:
                  %span.mr30 123
                  %span 总付款人数:
                  %span 70

                %span.select-page.tag2-page
                  %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                  %span.choice-page
                    != $items->links()
@endsection


@section('script')
<script src="js/admin_offline_show.js"></script>

@endsection