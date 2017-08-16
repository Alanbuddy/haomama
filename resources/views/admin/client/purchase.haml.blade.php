@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_client_show.css') }}">
:javascript
  window.client_desc="#{route('admin.user.log',$user->id)}"
  window.client_purchase="#{route('admin.user.order',$user->id)}"
  window.attendence = "#{route('admin.user.course.attendance',['user'=>$user->id,'course'=>-1])}"

@endsection
@section('search-input')
%a{href: route('users.index')."?type=user"}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')

.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li
          %a.f16.font-color1#desc 访问详情
        %li.active
          %a.f16.font-color1#pay 课程购买
      .tab-content.bg3
        #tab2.tab-pane.active
          .desc-div
            - if(count($items) != 0) 
              .undiscover.f14
                %img.undiscover-icon{src: "icon/admin/undiscover.png"}
            - else
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
                    - foreach($items as $item)
                      %tr{data-id => $item->course->id}
                        %td= $item->course->name
                        %td= $item->course->type
                        %td= $item->course->category ? $item->course->category->name : "无"
                        %td= $item->created_at
                        %td= $item->wx_total_fee
                        - if($item->status == 'paid')
                          %td.font-color-brown 已付款
                        - else
                          %td 未付款
                        %td 
                          - if($item->status == 'paid')
                            %a.details{:href => "javascript:void(0);"} 
                              上课情况
                              %span.triangle-down
                          - else
                            .pay-fail
                      - if($item->status == "paid")
                        %tr.status
                          %td{colspan: "7"}
                            .course-status
                              %span.item-status 上课状态：
                              - foreach($item->course->length)
                                %span.square
                            
              .tag2-foot.clearfix
                %span.num-div.font-color3.f16
                  %span 关注时间:
                  %span.mr30= $user->created_at

                %span.select-page.tag2-page
                  %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                  %span.choice-page
                    != $items->links()

@endsection

@section('script')
<script src= "{{mix('/js/admin_client_show.js')}}"></script>

@endsection