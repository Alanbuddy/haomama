@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/teacher.css') }}">
:javascript
  window.course_item = "#{route('courses.index')}"
  window.vote = "#{route('users.vote', $user['id'])}"

@endsection
@section('content')
.head-div
  %a{onClick: "javascript: window.history.back(); return false;"}
    %img.back{src: "icon/back2.png"}
.profile-div
  %p.name.f16.fb.color1= $user->name."老师"
  - if($user->description->title)
    .row-div.f12.color6
      %label 职称：
      %span= $user->description->title
  - if($user->description->major)
    .row-div.f12.color6
      %label 专长：
      %span= $user->description->major
  - if($user->description->award)
    .row-div.f12.color6
      %label 获奖：
      %span= $user->description->award
  - if($user->description->book)
    .row-div.f12.color6
      %label 出书：
      %span= $user->description->book
  .row-div.f12.color6
    %label 简介：
    %span.teacher-info!= $user->description->introduction
  .avatar-div
    %img.teacher-avatar{src: $user['avatar'] ? strpos($user['avatar'], '/') == 0 ? substr($user['avatar'],1) :$user['avatar'] : "icon/teacher_avatar.png"}
  - if ($hasVoted == false)
    .admire-div
      %img.admire-icon{src: "icon/like2_normal.png"}
      %span.f14.color8= count($votes)
  - else
    .admire-div.bc
      %img.admire-icon{src: "icon/like2_selected.png"}
      %span.f14.color12= count($votes)
    
.div-line
.course-item-div
  - foreach ($courses as $course)
    .course-item{"data-id" => $course['id']}
      .course-icon-div
        %img.course-icon{src: $course['cover'] ? strpos($course['cover'], '/') == 0 ? substr($course['cover'],1) :$course['cover'] : "icon/example.png"}
      .word-div
        .course-row-div.clearfix
          %span.f12.category-class= $course['category']['name']
          %span.course-item-value.f14.color5= $course['price'] ? "￥". $course['price'] : "￥".$course['original_price']
        .course-row-div.color7.unstart
          %span.name-span.f16= str_limit($course['name'], $limit = 24, $end = '...')
          - if ($course['type'] == 'offline')
            %span.course-status.f8 线下
            // %span.course-status.f8 线下    获取到用户的地理位置不在本地时不显示线下两字
        .course-row-div.f12.color6
          - if ($course['type'] == 'offline')
            %span.participate= $course['users_count']."人已报名"
            %span .
            %span= date_format(date_create($course['begin']),"m月d日") ."开课"
          - else
            %span.participate= $course['users_count']."人已学"
            %span .
            %span= $course['comments_count'] ."条评论"

@endsection

@section('script')
<script src= "{{ mix('/js/teacher.js') }}"></script>
@endsection
