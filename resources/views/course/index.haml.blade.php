@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/course-index.css') }}">

@endsection

@section('content')
.head-div
  .search-div.f12
    %img.search{src: '/icon/search.png'}
    %input.search-input.color5{type: "text", placeholder: "搜索课程名/老师名"}
  .nav-div
    %ul.nav.f14
      %li.active
        %a#feed{:href => "#"} 新课速递
      %li
        %a#health{:href => "#"} 健康教育
      %li
        %a#psychology{:href => "#"} 心理教育
      %li
        %a#grow{:href => "#"} 自我成长
.img_gallery
  .point
    %a{:href => "#"} 1
    %a{:href => "#"} 2
    %a{:href => "#"} 3
  .main_img
    %ul
      %li
        %a{:href => "#"}
          %img.img-size.img_1{src: '/icon/banner.png'}
      %li
        %a{:href => "#"}
          %img.img-size.img_2{src: '/icon/banner.png'}
      %li
        %a{:href => "#"}
          %img.img-size.img_3{src: '/icon/banner.png'}
    %a#btn_prev{:href => "#"}
    %a#btn_next{:href => "#"}
.course-title-div.clearfix
  %p.fl.color7.fb.f14 新课速递
  %ul.fr.course-nav.f12
    %li
      %a#feed-course.course-active{:href => "#"} 最新
    %li
      %a#hot-course{:href => "#"} 最热
    %li
      %a#good-review.no-border{:href => "#"} 好评
.course-item-div
  .course-item
    .course-icon-div
      %img.course-recommend{src: "/icon/recommend.png"}
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
      %img.course-recommend{src: "/icon/recommend.png"}
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
      %img.course-recommend{src: "/icon/recommend.png"}
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
  
.foot
  .foot-item-div#home
    %img.home{src: "/icon/home_selected.png"}
    %p.f10.color8 首页
  .foot-item-div#mine
    %img.mine{src: "/icon/mine_normal.png"}
    %p.f10.color5 我的

@endsection

@section('script')

<script src= "/js/jquery.event.drag.js"></script>
<script src= "/js/jquery.touchSlider.js"></script>
<script src= "/js/banner.js"></script>
  

@endsection


