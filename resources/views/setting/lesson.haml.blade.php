@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/creview.css') }}">

@endsection
@section('content')
.head-div
  %img.back{src: "/icon/back2.png"}
  %img.course-photo{src: "/icon/course.png"}
%ul.nav
  %li.active 详情
  %li 评论
.main-div{style: "display:block"}
  .title-div
    .row-div.clearfix
      %span.name.f18.color7.fb= $item['name']
      %span.num.f12.color5 1113人已学
    %p.f14.color6 名字很长很长-第1课
  .div-line
  .dir-div
    %span.title.f14.color7.fb 课程目录
    .nums-div
      %a.common
        %img.free-icon{src: "/icon/free.png"}
        1
      %a.common 1
      %a.common 1
      %a.common 1
      %a.common 1
      %a.common 1
      %a.common 1
      %a.common 1
      %a.common 1
      %a.common 1
      //未购买的免费课和购买后的新增课程均为red-border
      %a.red-border
        %img.new-icon{src: "/icon/new.png"}
        2
      %a.unopen 3
  .div-line
  .desc-div.f14.color7
    %span.fb 本课内容
    .desc 这是一门直播的课程.......

.main-div
  .hot-review-div
    .review-title
      %span.title.f14.color7.fb 课程评论
      %span.f12.color7 (共810条)
      %p.review-score.f12.color5 4.8分/2100人已评
    .review-items-div
      .review-item
        %img.review-avatar{src: "/icon/avatar.png"}
        .item-desc
          %p.f12.color7.review-name 最赞评论者
          %p.f12.color5 3天前
          %p.f14.color7.review-content 这是评论 
          %span.f12.color5 评论来源：
          %span.f12.color5 第1课时
          .admire-div
            %span.f12.color5.admire-num 123
            %img.admire-icon{src: "/icon/like1_normal.png"}
      .review-item
        %img.review-avatar{src: "/icon/avatar.png"}
        .item-desc
          %p.f12.color7.review-name 二赞评论者
          %p.f12.color5 3天前
          %p.f14.color7.review-content 这是评论 
          %span.f12.color5 评论来源：
          %span.f12.color5 第1课时
          .admire-div
            %span.f12.color5.admire-num 123
            %img.admire-icon{src: "/icon/like1_selected.png"}
      .review-item
        %img.review-avatar{src: "/icon/avatar.png"}
        .item-desc
          %p.f12.color7.review-name 三赞评论者
          %p.f12.color5 3天前
          %p.f14.color7.review-content 这是评论 
          %span.f12.color5 评论来源：
          %span.f12.color5 第1课时
          .admire-div
            %span.f12.color5.admire-num 123
            %img.admire-icon{src: "/icon/like1_normal.png"}
  %p.f12.color6.feed-review 最新评论
  .feed-review-items-div
    .feed-review-item
      %img.review-avatar{src: "/icon/avatar.png"}
      .item-desc
        %p.f12.color7.review-name 评论者
        %p.f12.color5 3天前
        %p.f14.color7.review-content 这是评论 
        %span.f12.color5 评论来源：
        %span.f12.color5 第1课时
        .admire-div
          %span.f12.color5.admire-num 123
          %img.admire-icon{src: "/icon/like1_normal.png"}
    .feed-review-item
      %img.review-avatar{src: "/icon/avatar.png"}
      .item-desc
        %p.f12.color7.review-name 评论者
        %p.f12.color5 3天前
        %p.f14.color7.review-content 这是评论 
        %span.f12.color5 评论来源：
        %span.f12.color5 第1课时
        .admire-div
          %span.f12.color5.admire-num 123
          %img.admire-icon{src: "/icon/like1_normal.png"}
@endsection
@section('foot-div')
//未购买时不显示底部评论input
.foot-div
  %input.review-input{placeholder: "写评论......"}
  .btn#delivery 发送
@endsection
#confirmModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modal-body
        %p.prompt 未报名课程
        %p.question　确认立即报名当前课程？
        .confirm-div
          %a#register 报名
          %a{"data-dismiss" => "modal"} 取消
      


@section('script')
<script src= "{{ mix('/js/creview.js') }}"></script>
<script src= "/js/prompt.js"></script>
@endsection