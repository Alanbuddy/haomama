@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/teacher.css') }}">
:javascript
  window.course_item = "#{route('courses.index')}"

@endsection
@section('content')
.head-div
  %img.back{src: "/icon/back2.png"}
.profile-div
  %p.name.f16.fb.color1 张老师
  .row-div.f12.color6
    %label 职称：
    %span
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
  - foreach ($courses as $course)
    .course-item{"data-id" => $course['id']}
      .course-icon-div
        %img.course-icon{src: $course['cover'] ? $course['cover'] : "/icon/example.png"}
      .word-div
        .course-row-div.clearfix
          %span.f12.category-class= $course['category']['name']
          %span.course-item-value.f14.color5= "￥". $course['price']
        .course-row-div.color7.unstart
          %span.name-span.f16= $course['name']
          - if ($course['type'] == 'offline')
            %span.course-status.f8 线下
            // %span.course-status.f8 线下    获取到用户的地理位置不在本地时不显示线下两字
        .course-row-div.f12.color6
          - if ($course['type'] == 'offline')
            %span.participate= $course['users_count']."人已报名"
            %span .
            %span= date_format(date_create($course['begin']),"m月/d日") ."开课"
          - else
            %span.participate= $course['users_count']."人已学"
            %span .
            %span= $course['comments_count'] ."条评论"

@endsection

@section('script')
<script src= "{{ mix('/js/teacher.js') }}"></script>
@endsection