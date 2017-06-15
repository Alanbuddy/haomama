@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mine-show.css') }}">

@endsection
@section('content')
.head-div
  %p.fb.tc.fb.color7.f18 我的收藏
  %img.back{src: "/icon/back.png"}
  %hr.div-line
- if (!$items)
  .empty-div
    %img.empty-icon{src: "/icon/empty.png"}
    %p.empty-message.f12.color5 您还没有相关课程信息......
.course-item-div
  - foreach ($items as $item)
    .course-item
      .course-icon-div
        %img.course-icon{src: $item['cover'] ? $item['cover'] : "/icon/example.png"}
      .word-div
        .course-row-div.clearfix
          %span.f12.category-class= $item['category']['name']
          %span.course-item-value.f14.color5= "￥". $item['price']
        .course-row-div.color7
          %span.name-span.f16= $item['name']
          - if ($item['type'] == 'offline')
            %span.course-status.f8 线下
        .course-row-div.f12.color6
          %span.participate= $item['users_count']."人已学"
          %span .
          - if ($item['type'] == "offline")
            %span= date_format(date_create($item['begin']),"m月/d日")."开课"
          - else
            %span= $item['comments_count'] ."条评论"
@endsection


@section('script')
<script src= "{{ mix('/js/mine-show.js') }}"></script>
<script src= "/js/profile.js"></script>
@endsection