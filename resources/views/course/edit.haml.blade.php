@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/search-result.css') }}">

@endsection

@section('content')
.search-box
  %img.back{src: "/icon/back.png"}
  %p.fb.color7.f18 搜索结果
.course-item-div
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
@endsection

@section('script')
<script src= "{{ mix('/js/search-result.js') }}"></script>
@endsection