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
  %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{:type => "button", "data-target" => "#noticeModal", "data-toggle" => "modal"} 编辑通知
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
                        %td 
                          - if($item->status == 'paid')
                            %a.details{:href => "javascript:void(0);"} 
                              上课情况
                              %span.triangle-down
                          - else
                            .pay-fail 无

                      - if($item->status == "paid")
                        %tr.status
                          %td{colspan: "7"}
                            .course-status
                              %span.item-status 上课状态:
              .tag2-foot.clearfix
                %span.num-div.font-color3.f16
                  %span 总购买人数:
                  %span.mr30= $items->total()
                  %span 总付款人数:
                  %span= $items->total()

                %span.select-page.tag2-page
                  %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                  %span.choice-page
                    != $items->links()
#noticeModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/admin/close.png"}
      .modal-body
        .notice-div
          %p.notice-content 请编辑通知的内容:
          %p.notice-content 您报名的课程有变动！
          %span.notice-content 课程名称:
          %span.notice-content= $course->name
          .notice-textarea
            %span.notice-content.vt 情况说明:
            %textarea.text-div{placeholder: "课程变动的原因解释"}
          %p.notice-content.notice-bottom 好妈妈微学院祝您上课愉快!
          .btn.delivery-btn{:type => "button"} 发送通知
          // - if @course_inst.messages.present?
          //   - @course_inst.messages.each do |m|
          //     .message-div
          //       %span.notice-date= m.created_at.strftime("%Y-%m-%d %H:%M") + "已发送"
          //       %span.notice-message 课程调整通知
          //       %p.display-message= m.content
@endsection


@section('script')
<script src="js/offline_student.js"></script>

@endsection