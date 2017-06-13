@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mine-index.css') }}">
@endsection
:javascript
  window.home = "#{route('index')}"
  window.course = "#{route('courses.index')}"
  window.enrolled_course = "#{route('courses.enrolled')}"
  window.favorited_course = "#{route('courses.favorited')}"

@section('content')

.head-div
  .avatar-div
    - if ($user)
      %img.avatar-icon{src: "/icon/avatar.png"}
      %p.name.f16.color7= $user['name']
    .right-div
      %a.f12.color5{href: "#"} 个人资料
      %img.arrow{src: "/icon/go.png"}
  %img.message-icon{src: "/icon/message.png"}
  //有消息时显示小红点
  %img.small-circle{src: "/icon/small-dot.png"}
%hr.div-line
- if (count($onGoingCourses) == 0 && count($enrolledCourses) == 0 && count($favoritedCourses) == 0)
  .empty-div
    %img.empty-icon{src: "/icon/empty.png"}
    %p.empty-message.f12.color5 您还没有相关课程信息......
- else
  - if (count($onGoingCourses) > 0)
    .course-div
      %p.f14.color7.fb.mb28.title 待参加课程
      - foreach ($onGoingCourses as $onGoingCourse)
        .item{'data-id' => $onGoingCourse['id']}
          .item-left
            .category-class.f12.fb.color9= $onGoingCourse['category']['name']
            %p.course-name.f16.color7= $onGoingCourse['name']
            .row-divf.f12.color6
              %span 时间：
              %span= $onGoingCourse['time']
            .row-div.f12.color6
              %span.address-span 地址：
              %span.address= $onGoingCourse['name']
          .item-right
            %img.signin{src: "/icon/signin.png"}
  %hr.div-line
  - if (count($enrolledCourses) > 0)
    .course-div.enrolled-course
      .title-div.clearfix
        %span.f14.color7.fb.mb12 我的课程
        %span.course-more.f10.color5.fr 更多
      - foreach ($enrolledCourses as $enrolledCourse)
        .favorite-item{'data-id' => $enrolledCourse['id']}
          .icon-div
            %img.icon{src: $enrolledCourse['cover'] ? $enrolledCourse['cover'] :"/icon/example.png"}
          .word-div
            .favorite-row-div.clearfix
              %span.category-class.f12= $enrolledCourse['category']['name']
              %span.item-value.f14.color5= "￥".$enrolledCourse['price']
            .favorite-row-div.color7.unstart
              %span.favorite-name.f16= $enrolledCourse['name']
              - if ($enrolledCourse['type'] == 'offline')
                %span.course-status.f8 线下
            .favorite-row-div.f12.color6
              %span.participate= $enrolledCourse['users_count']."人已报名"
              %span .
              %span= date_format(date_create($enrolledCourse['begin']),"m月/d日")."开课"
  .hr.div-line
  - if (count($favoritedCourses) > 0)
    .course-div.favorite-div
      .title-div.clearfix
        %span.f14.color7.fb.mb12 我的收藏
        %span.favorite-more.f10.color5.fr 更多
      - foreach ($favoritedCourses as $favoritedCourse)
        .favorite-item{'data-id' => $favoritedCourse['id']}
          .icon-div
            %img.icon{src: $favoritedCourse['cover'] ? $favoritedCourse['cover'] :"/icon/example.png"}
          .word-div
            .favorite-row-div.clearfix
              %span.category-class.f12= $favoritedCourse['category']['name']
              %span.item-value.f14.color5= "￥".$favoritedCourse['price']
            .favorite-row-div.color7.unstart
              %span.favorite-name.f16= $favoritedCourse['name']
              - if ($favoritedCourse['type'] == 'offline')
                %span.course-status.f8 线下
            .favorite-row-div.f12.color6
              %span.participate= $favoritedCourse['users_count']."人已报名"
              %span .
              %span= date_format(date_create($favoritedCourse['begin']),"m月/d日")."开课"
.foot
  .foot-item-div#home
    %img.home{src: "/icon/home_normal.png"}
    %p.f10.color5 首页
  .foot-item-div#mine
    %img.mine{src: "/icon/mine_selected.png"}
    %p.f10.color8.fb 我的

@endsection

@section('script')
<script src= "{{ mix('/js/mine-index.js') }}"></script>
@endsection