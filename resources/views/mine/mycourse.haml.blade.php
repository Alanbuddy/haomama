@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mycourse.css') }}">
:javascript
  window.userid = "#{route('user.account')}"
  window.course = "#{route('courses.index')}"
@endsection
@section('header')
.head-div
  %p.fb.tc.fb.color7.f18 我的课程
  %img.back{src: "icon/back.png"}
  %hr.div-line
@endsection
@section('content')
// .head-div
//   %p.fb.tc.fb.color7.f18 我的课程
//   %img.back{src: "icon/back.png"}
//   %hr.div-line
- if (count($items) == 0)
  .empty-div
    %img.empty-icon{src: "icon/empty.png"}
    %p.empty-message.f12.color5 您还没有相关课程信息......
- else
  .course-item-div
    - foreach ($items as $item)
      .course-item{"data-id" => $item->id}
        .course-icon-div
          %img.course-icon{src: $item['cover'] ? strpos($item['cover'], '/') == 0 ? substr($item['cover'],1) :$item['cover'] : "icon/example.png"}
        .word-div
          .course-row-div.clearfix
            %span.f12.category-class= $item['category']['name']
            %span.course-item-value.f14.color5= "￥". ($item['price'] ? $item['price'] : $item['original_price'])
          .course-row-div.color7
            - if ($item['type'] == 'offline')
              %span.name-span.f16= str_limit($item['name'], $limit = 24, $end = '...')
              %span.course-status.f8 线下
            - else 
              %span.course-name.f16= $item['name']
          .course-row-div.f12.color6
            - if ($item['type'] == "offline")
              %span.participate= $item['users_count']."人已报名"
              %span .
              %span= date_format(date_create($item['begin']),"m月d日")."开课"
            - else
              %span.participate= $item['users_count']."人已学"
              %span .
              %span= $item['comments_count'] ."条评论"
@endsection


@section('script')
<script src= "{{ mix('/js/mycourse.js') }}"></script>
@endsection