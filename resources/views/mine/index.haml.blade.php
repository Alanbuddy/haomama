@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mine-index.css') }}">
@endsection

@section('content')

.head-div
  .avatar-div
    %img.avatar-icon{src: "/icon/avatar.png"}
    %p.name.f16.color7 名字很长很长名字很长很长很长名
    .right-div
      %a.f12.color5{href: "#"} 个人资料
      %img.arrow{src: "/icon/go.png"}
  %img.message-icon{src: "/icon/message.png"}
%hr.div-line
.empty-div
  %img.empty-icon{src: "/icon/empty.png"}
  %p.empty-message.f12.color5 您还没有相关课程信息......
.course-div
  %p.f14.color7.fb.mb32 待参加课程
  .item
    .item-left
      .health-title.f12.fb.color9 健康教育
      %p.course-name.f16.color7 课程名字很长
      .row-divf.f12.color6
        %span 时间：
        %span 5/20、6/20、7/20
      .row-div.f12.color6
        %span.address-span 地址：
        %span.address 北京市北京市北京市北京市北京市北京市北京市北京市
    .item-right
      %img.signin{src: "/icon/signin.png"}
  .item
    .item-left
      .health-title.f12.fb.color9 健康教育
      %p.course-name.f16.color7 课程名字很长
      .row-divf.f12.color6
        %span 时间：
        %span 5/20、6/20、7/20
      .row-div.f12.color6
        %span.address-span 地址：
        %span.address 北京市北京市北京市北京市北京市北京市北京市北京市
    .item-right
      %img.signin{src: "/icon/signin.png"}
  .item
    .item-left
      .health-title.f12.fb.color9 健康教育
      %p.course-name.f16.color7 课程名字很长
      .row-divf.f12.color6
        %span 时间：
        %span 5/20、6/20、7/20
      .row-div.f12.color6
        %span.address-span 地址：
        %span.address 北京市北京市北京市北京市北京市北京市北京市北京市
    .item-right
      %img.signin{src: "/icon/signin.png"}
%hr.div-line
.course-div
  .title-div.clearfix
    %span.f14.color7.fb.mb12 我的课程
    %span.course-more.f10.color5.fr 更多
  .favorite-item
    .icon-div
      %img.icon{src: "/icon/example.png"}
    .word-div
      .favorite-row-div.clearfix
        %span.psychology-title.f12 心理教育
        %span.item-value.f14.color5 200
      .favorite-row-div.color7.unstart
        %span.favorite-name.f16 名字很长很长很长
        %span.course-status.f8 线下
      .favorite-row-div.f12.color6
        %span.participate 2315人已报名
        %span .
        %span 5月9日开课
  .favorite-item
    .icon-div
      %img.icon{src: "/icon/example.png"}
    .word-div
      .favorite-row-div.clearfix
        %span.grow-title.f12 自我成长
        %span.item-value.f14.color5 200
      .favorite-row-div.color7
        %span.coures-name.f16 名字很长很长很长
        // %span.course-status.f8 线下
      .favorite-row-div.f12.color6
        %span.participate 2315人已学
        %span .
        %span 810条评论
.hr.div-line
.course-div
  .title-div.clearfix
    %span.f14.color7.fb.mb12 我的收藏
    %span.favorite-more.f10.color5.fr 更多
  .favorite-item
    .icon-div
      %img.icon{src: "/icon/example.png"}
    .word-div
      .favorite-row-div.clearfix
        %span.psychology-title.f12 心理教育
        %span.item-value.f14.color5 200
      .favorite-row-div.color7.unstart
        %span.favorite-name.f16 名字很长很长很长
        %span.course-status.f8 线下
      .favorite-row-div.f12.color6
        %span.participate 2315人已报名
        %span .
        %span 5月9日开课
  .favorite-item
    .icon-div
      %img.icon{src: "/icon/example.png"}
    .word-div
      .favorite-row-div.clearfix
        %span.grow-title.f12 自我成长
        %span.item-value.f14.color5 200
      .favorite-row-div.color7
        %span.coures-name.f16 名字很长很长很长
        // %span.course-status.f8 线下
      .favorite-row-div.f12.color6
        %span.participate 2315人已学
        %span .
        %span 810条评论
.foot
  .foot-item-div#home
    %img.home{src: "/icon/home_normal.png"}
    %p.f10.color5 首页
  .foot-item-div#mine
    %img.mine{src: "/icon/mine_selected.png"}
    %p.f10.color8 我的

@endsection

@section('script')
<script src= "{{ mix('/js/mine-index.js') }}"></script>
@endsection