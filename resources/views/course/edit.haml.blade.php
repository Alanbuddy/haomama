@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/search-result.css') }}">
:javascript
  window.home = "#{route('index')}"
  window.course_item="#{route('courses.index')}"

@endsection

@section('content')
.search-box
  %img.back{src: "icon/back.png"}
  %p.fb.color7.f18 搜索结果
- if (count($items) == 0)
  .empty-div
    %img.empty-icon{src: "icon/empty.png"}
    %p.empty-message.f12.color5 您还没有相关课程信息......
- else
  .course-item-div
    - foreach ($items as $item)
      .course-item{'data-id' => $item['id']}
        .course-icon-div
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
%img.upper{src: 'icon/top.png'}
@endsection

@section('script')
<script src= "{{ mix('/js/search-result.js') }}"></script>
@endsection