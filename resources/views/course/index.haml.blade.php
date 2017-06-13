@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/course-index.css') }}">
<link rel="stylesheet" href="/css/swiper-3.4.2.min.css">
:javascript
  window.course_item="#{route('courses.index')}"
  window.userid = "#{route('users.show',auth()->user())}"
@endsection
@section('header')
.head-div
  .search-div.f12
    %img.search{src: '/icon/search.png'}
    %input.search-input.color5{type: "text", placeholder: "搜索课程名/老师名"}
  .nav-div
    %ul.nav.f14
      %li 新课速递
      // %li 健康教育
      // %li 心理教育
      // %li 自我成长   
      - foreach ($categories as $category )
        %li= $category['name']
        
@endsection
@section('content')
.swiper-container-banner
  .swiper-wrapper
    .swiper-slide
      %img.img-size.img_1{src: '/icon/banner.png'}
    .swiper-slide
      %img.img-size.img_1{src: '/icon/banner.png'}
    .swiper-slide
      %img.img-size.img_1{src: '/icon/banner.png'}
  .swiper-pagination
// .main-div
.swiper-container
  .swiper-wrapper
    .swiper-slide
      .course-title-div
        .title-row-div
          %p.color7.fb.f14 新课速递
          .course-nav.f12.color5
            %span.course-active 最新
            %span 最热
            %span 好评
        .course-item-div{style: "display:block"}
          - foreach ($items as $item)
            .course-item{'data-id' => $item['id']}
              .course-icon-div
                %img.course-recommend{src: "/icon/recommend.png"}
                %img.course-icon{src: $item['cover'] ? $item['cover'] : "/icon/example.png"}
              .word-div
                .course-row-div.clearfix
                  %span.f12.category-class= $item['category']['name']
                  %span.course-item-value.f14.color5= "￥". $item['price']
                .course-row-div.color7
                  %span.coures-name.f16= $item['name']
                  - if ($item['type'] == 'offline')
                    %span.course-status.f8 线下
                .course-row-div.f12.color6
                  %span.participate= $item['users_count']."人已学"
                  %span .
                  %span= $item['comments_count'] ."条评论"
        
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
        .course-item-div
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
    .swiper-slide
      .course-title-div
        .title-row-div
          %p.color7.fb.f14 健康教育
          .course-nav.f12.color5
            %span.course-active 最新
            %span 最热
            %span 好评
        .course-item-div{style: "display:block"}
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
                %span.health-title.f12 健康教育
                %span.course-item-value.f14.color5 200
              .course-row-div.color7.status-flex
                %span.name-span.f16 名字很长很长很长
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
                %span.health-title.f12 健康教育
                %span.course-item-value.f14.color5 200
              .course-row-div.color7
                %span.coures-name.f16 名字很长很长很长
                // %span.course-status.f8 线下
              .course-row-div.f12.color6
                %span.participate 2315人已学
                %span .
                %span 810条评论
          
        .course-item-div
          .course-item
            .course-icon-div
              %img.course-recommend{src: "/icon/recommend.png"}
              %img.course-icon{src: "/icon/example.png"}
            .word-div
              .course-row-div.clearfix
                %span.health-title.f12 健康教育
                %span.course-item-value.f14.color5 200
              .course-row-div.color7
                %span.coures-name.f16 名字很长很长很长
                // %span.course-status.f8 线下
              .course-row-div.f12.color6
                %span.participate 2315人已学
                %span .
                %span 810条评论
        .course-item-div
          .course-item
            .course-icon-div
              %img.course-recommend{src: "/icon/recommend.png"}
              %img.course-icon{src: "/icon/example.png"}
            .word-div
              .course-row-div.clearfix
                %span.health-title.f12 健康教育
                %span.course-item-value.f14.color5 200
              .course-row-div.color7
                %span.coures-name.f16 名字很长很长很长
                // %span.course-status.f8 线下
              .course-row-div.f12.color6
                %span.participate 2315人已学
                %span .
                %span 810条评论
    .swiper-slide
      .course-title-div
        .title-row-div
          %p.color7.fb.f14 心理教育
          .course-nav.f12.color5
            %span.course-active 最新
            %span 最热
            %span 好评
        .course-item-div{style: "display:block"}
          .course-item
            .course-icon-div
              %img.course-recommend{src: "/icon/recommend.png"}
              %img.course-icon{src: "/icon/example.png"}
            .word-div
              .course-row-div.clearfix
                %span.psychology-title.f12 心理教育
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
              .course-row-div.color7.status-flex
                %span.name-span.f16 名字很长很长很长
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
                %span.psychology-title.f12 心理教育
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
              .course-row-div.color7
                %span.coures-name.f16 名字很长很长很长
                // %span.course-status.f8 线下
              .course-row-div.f12.color6
                %span.participate 2315人已学
                %span .
                %span 810条评论
        .course-item-div
          .course-item
            .course-icon-div
              %img.course-recommend{src: "/icon/recommend.png"}
              %img.course-icon{src: "/icon/example.png"}
            .word-div
              .course-row-div.clearfix
                %span.psychology-title.f12 心理教育
                %span.course-item-value.f14.color5 200
              .course-row-div.color7
                %span.coures-name.f16 名字很长很长很长
                // %span.course-status.f8 线下
              .course-row-div.f12.color6
                %span.participate 2315人已学
                %span .
                %span 810条评论
        .course-item-div
          .course-item
            .course-icon-div
              %img.course-recommend{src: "/icon/recommend.png"}
              %img.course-icon{src: "/icon/example.png"}
            .word-div
              .course-row-div.clearfix
                %span.psychology-title.f12 心理教育
                %span.course-item-value.f14.color5 200
              .course-row-div.color7
                %span.coures-name.f16 名字很长很长很长
                // %span.course-status.f8 线下
              .course-row-div.f12.color6
                %span.participate 2315人已学
                %span .
                %span 810条评论
    .swiper-slide
      .course-title-div
        .title-row-div
          %p.color7.fb.f14 自我成长
          .course-nav.f12.color5
            %span.course-active 最新
            %span 最热
            %span 好评
        .course-item-div{style: "display:block"}
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
          .course-item
            .course-icon-div
              %img.course-recommend{src: "/icon/recommend.png"}
              %img.course-icon{src: "/icon/example.png"}
            .word-div
              .course-row-div.clearfix
                %span.grow-title.f12 自我成长
                %span.course-item-value.f14.color5 200
              .course-row-div.color7.status-flex
                %span.name-span.f16 名字很长很长很长
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
        .course-item-div
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
        .course-item-div
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
%img.upper{src: "/icon/top.png"}

@endsection

@section('foot-div')
.foot
  .foot-item-div#home
    %img.home{src: "/icon/home_selected.png"}
    %p.f10.color8.fb 首页
  .foot-item-div#mine
    %img.mine{src: "/icon/mine_normal.png"}
    %p.f10.color5 我的
@endsection
  
</section>
@section('script')
<script src= "/js/jquery.event.drag.js"></script>
<script src= "/js/jquery.touchSlider.js"></script>
<script src= "/js/banner.js"></script>
<script src= "{{mix('/js/course-index.js')}}"></script>
<script src= "/js/swiper-3.4.2.jquery.min.js"></script>
@endsection

