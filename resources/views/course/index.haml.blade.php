@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{mix('/css/course-index.css') }}">
<link rel="stylesheet" href="css/swiper-3.4.2.min.css">
:javascript
  window.course_item="#{route('courses.index')}"
  window.course_search="#{route('courses.search')}"
  window.userid = "#{route('users.show',auth()->user())}"
@endsection
@section('header')
.head-div
  .search-div.f12
    %img.search{src: 'icon/search.png'}
    %input.search-input.color5{type: "text", placeholder: "搜索课程名/老师名", readonly: "readonly"}
  .nav-div
    %ul.nav.f14
      // %li 新课速递
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
      %img.img-size.img_1{src: 'icon/banner.png'}
    .swiper-slide
      %img.img-size.img_1{src: 'icon/banner.png'}
    .swiper-slide
      %img.img-size.img_1{src: 'icon/banner.png'}
  .swiper-pagination
// .main-div
.swiper-container
  .swiper-wrapper
    - for ($i=0;$i<4;$i++)
      .swiper-slide
        .course-title-div
          .title-row-div
            %p.color7.fb.f14= $categories[$i]['name']
            .course-nav.f12.color5
              %span.course-active 最新
              %span 最热
              %span 好评
          .course-item-div{style: "display:block"}
            - foreach ($data[$i]['items'] as $item)
              .course-item{'data-id' => $item['id']}
                .course-icon-div
                  %img.course-recommend{src: "icon/recommend.png"}
                  %img.course-icon{src: $item['cover'] ? $item['cover'] : "icon/example.png"}
                .word-div
                  .course-row-div.clearfix
                    %span.f12.category-class= $item['category']['name']
                    %span.course-item-value.f14.color5= "￥". $item['price']
                  .course-row-div.color7.unstart
                    %span.coures-name.f16= $item['name']
                    - if ($item['type'] == 'offline')
                      %span.course-status.f8 线下
                  .course-row-div.f12.color6
                    - if ($item['type'] == 'offline')
                      %span.participate= $item['users_count']."人已报名"
                      %span .
                      %span= date_format(date_create($item['begin']),"m月/d日") ."开课"
                    - else
                      %span.participate= $item['users_count']."人已学"
                      %span .
                      %span= $item['comments_count'] ."条评论"
          .course-item-div
            - foreach ($data[$i]['itemsOrderByUserCount'] as $itemOrderByUserCount)
              .course-item{'data-id' => $itemOrderByUserCount['id']}
                .course-icon-div
                  %img.course-recommend{src: "icon/recommend.png"}
                  %img.course-icon{src: $itemOrderByUserCount['cover'] ? $itemOrderByUserCount['cover'] : "icon/example.png"}
                .word-div
                  .course-row-div.clearfix
                    %span.category-class.f12= $itemOrderByUserCount['category']['name']
                    %span.course-item-value.f14.color5= "￥". $itemOrderByUserCount['price']
                  .course-row-div.color7.unstart
                    %span.coures-name.f16= $itemOrderByUserCount['name']
                    - if ($itemOrderByUserCount['type'] == 'offline')
                      %span.course-status.f8 线下
                  .course-row-div.f12.color6
                    - if ($itemOrderByUserCount['type'] == 'offline')
                      %span.participate= $itemOrderByUserCount['users_count']."人已报名"
                      %span .
                      %span= date_format(date_create($itemOrderByUserCount['begin']),"m月/d日") ."开课"
                    - else
                      %span.participate= $itemOrderByUserCount['users_count']."人已学"
                      %span .
                      %spann= $itemOrderByUserCount['comments_count'] ."条评论"
          .course-item-div
            - foreach ($data[$i]['itemsOrderByCommentRating'] as $itemOrderByCommentRating)
              .course-item{'data-id' => $itemOrderByCommentRating['id']}
                .course-icon-div
                  %img.course-recommend{src: "icon/recommend.png"}
                  %img.course-icon{src: $itemOrderByCommentRating['cover'] ? $itemOrderByCommentRating['cover'] : "icon/example.png"}
                .word-div
                  .course-row-div.clearfix
                    %span.category-class.f12= $itemOrderByCommentRating['category']['name']
                    %span.course-item-value.f14.color5= "￥". $itemOrderByCommentRating['price']
                  .course-row-div.color7.unstart
                    %span.coures-name.f16= $itemOrderByCommentRating['name']
                    - if ($itemOrderByCommentRating['type'] == 'offline')
                      %span.course-status.f8 线下
                  .course-row-div.f12.color6
                    - if ($itemOrderByCommentRating['type'] == 'offline')
                      %span.participate= $itemOrderByCommentRating['users_count']."人已报名"
                      %span .
                      %span= date_format(date_create($itemOrderByCommentRating['begin']),"m月/d日") ."开课"
                    - else
                      %span.participate= $itemOrderByCommentRating['users_count']."人已学"
                      %span .
                      %span= $itemOrderByCommentRating['comments_count'] ."条评论"
%img.upper{src: "icon/top.png"}

@endsection

@section('foot-div')
.foot
  .foot-item-div#home
    %img.home{src: "icon/home_selected.png"}
    %p.f10.color8.fb 首页
  .foot-item-div#mine
    %img.mine{src: "icon/mine_normal.png"}
    %p.f10.color5 我的
@endsection

@section('script')
<script src= "js/jquery.event.drag.js"></script>
<script src= "js/jquery.touchSlider.js"></script>
<script src= "js/banner.js"></script>
<script src= "{{mix('/js/course-index.js')}}"></script>
<script src= "js/swiper-3.4.2.jquery.min.js"></script>
@endsection

