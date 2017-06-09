@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/teacher.css') }}">

@endsection
@section('content')
.head-div
  %img.back{src: "/icon/back2.png"}
.profile-div
  %p.name.f16.fb.color1 张老师
  .row-div.f12.color6
    %label 职称：
    %span 某某医院科室主任医师
  .row-div.f12.color6
    %label 专长：
    %span 婴幼儿常见病
  .row-div.f12.color6
    %label 获奖：
    %span 第十届“中国好医师奖”第第十届“中国好医师奖”十届“中国好医师奖”
  .row-div.f12.color6
    %label 出书：
    %span 《聪明宝宝》
  .row-div.f12.color6
    %label 简介：
    %span 某某医院科室主任医师某某某某某某医院科室主任医师某医院科室主任医师某医院科室主任医师某医院科室主任医师某医院科室主任医师
  .avatar-div
    %img.teacher-avatar{src: "/icon/teacher_avatar.png"}
  .admire-div
    %img.admire-icon{src: "/icon/like2_normal.png"}
    %span.f14.color8 999
    // 赞后框和文字颜色变为ccc,like2_selected.png
.div-line
.course-item-div
  .course-item
    .course-icon-div
      %img.course-icon{src: "/icon/example.png"}
    .word-div
      .course-row-div.clearfix
        %span.health-title.f12 健康养育
        %span.course-item-value.f14.color5 200
      .course-row-div.color7
        %span.course-name.f16 名字很长很长很长
        // %span.course-status.f8 线下    获取到用户的地理位置不在本地时不显示线下两字
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
      .course-row-div.color7.status-flex
        %span.name-span.f16 名字很长名字很长名字很名字
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
        %span.course-name.f16 名字很长很长很长
        // %span.course-status.f8 线下
      .course-row-div.f12.color6
        %span.participate 2315人已学
        %span .
        %span 810条评论

@endsection

@section('script')
<script src= "{{ mix('/js/teacher.js') }}"></script>
@endsection