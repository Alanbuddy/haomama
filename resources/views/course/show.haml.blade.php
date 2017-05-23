@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/course-show.css') }}">

@endsection
@section('content')
.head-div
  %img.course-photo{src: "/icon/course.png"}
  %img.back{src: "/icon/back2.png"}
  %img.favorite{src: "/icon/like_normal.png"}
  .course-title-div
    .course-row-div.clearfix
      %span.health-title.f12 健康养育
    .course-row-div.color7
      %span.coures-name.f16.fb.color7 名字很长很长很长
    .btn#test-btn{type: "button"}
      %img.play{src: "/icon/play.png"}
      %span 立即试课
.desc-div
  %span.price-pay.f16.fb.color11 ¥200
  %span.price.f12.color6 ¥400
  %span.f12.color5 18人已报名
%hr.div-line
.course-content
  %span.title.f14.color7.fb 课程目录
  %span.f12.color7 (共8节)
  .items-div
    .item
      %p.num-div.f16.color7 1
      .item-desc
        %p.f14.color7 宝宝生长发育特点
        .item-row.f12.color5
          %span.min 23min
          %span 1233人已学
      %img.go{src: "/icon/go.png"}
      %img.free{src: "/icon/free.png"}
    .item.opt55
      %p.num-div.f16.color7 1
      .item-desc
        %p.f14.color7 宝宝生长发育特点
        .item-row.f12.color5
          %span.min 23min
          %span 1233人已学
      %img.go{src: "/icon/go.png"}
    .item.opt55
      %p.num-div.f16.color7 1
      .item-desc
        %p.f14.color7 宝宝生长发育特点
        .item-row.f12.color5
          %span 未上线
    .view-more
      %span.f12.color5 查看更多
      %img.more-icon{src: "/icon/more.png"}
%hr.div-line
.course-content
  %span.title.f14.color7.fb 授课老师
  %span.f12.color7 (共5位)
  .items-div
    .teacher-item
      %img.avatar{src: "/icon/avatar.png"}
      .item-desc
        %p.f14.color7.teacher-name 王小明老师
        %p.f12.color6 这里写的是老师的简介信息，不能写太长
    .teacher-item
      %img.avatar{src: "/icon/avatar.png"}
      .item-desc
        %p.f14.color7.teacher-name 王小明老师
        %p.f12.color6 这里写的是老师的简介信息，不能写太长
    .teacher-item
      %img.avatar{src: "/icon/avatar.png"}
      .item-desc
        %p.f14.color7.teacher-name 王小明老师
        %p.f12.color6 这里写的是老师的简介信息，不能写太长
    .view-more
      %span.f12.color5 查看更多
      %img.more-icon{src: "/icon/more.png"}
%hr.div-line
.course-desc
  %span.f14.color7.fb 课程介绍
  .desc-box.f14.color7 开始介绍这门课程...
%hr.div-line
.recommend-div
  %span.recommend-title.f14.color7.fb 推荐课程
  .course-item
    .course-icon-div
      %img.course-icon{src: "/icon/example.png"}
    .word-div
      .course-row-div.clearfix
        %span.health-title.f12 健康养育
        %span.course-item-value.f14.color5 200
      .course-row-div.color7
        %span.coures-name.f16 名字很长很长很长
        // %span.course-status.f8 线下
      .course-row-div.f12.color6
        %span.participate 2315人已学
        %span .
        %span 810条评论
  .course-item
    .course-icon-div
      %img.course-icon{src: "/icon/example.png"}
    .word-div
      .course-row-div.clearfix
        %span.psychology-title.f12 心理教育
        %span.course-item-value.f14.color5 200
      .course-row-div.color7.unstart
        %span.coures-name.f16 名字很长很长很长
        %span.course-status.f8 线下
      .course-row-div.f12.color6
        %span.participate 2315人已报名
        %span .
        %span 5月9日开课
  .course-item
    .course-icon-div
      %img.course-icon{src: "/icon/example.png"}
    .word-div
      .course-row-div.clearfix
        %span.grow-title.f12 自我成长
        %span.course-item-value.f14.color5 200
      .course-row-div.color7
        %span.coures-name.f16 名字很长很长很长
        // %span.course-status.f8 线下
      .course-row-div.f12.color6
        %span.participate 2315人已学
        %span .
        %span 810条评论
%hr.div-line
.course-content
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
%img.upper{src: "/icon/top.png"}
.btn#add-btn{type: "button"} 立即报名

@endsection

@section('script')
<script src= "{{ mix('/js/course-show.js') }}"></script>
@endsection