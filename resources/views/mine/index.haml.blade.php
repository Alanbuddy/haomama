@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/mine-index.css') }}">
@endsection
:javascript
  window.home = "#{route('index')}"
  window.course = "#{route('courses.index')}"
  window.enrolled_course = "#{route('courses.enrolled')}"
  window.favorited_course = "#{route('courses.favorited')}"
  window.profile = "#{route('user.profile')}"
  window.message = "#{route('messages.index')}"

@section('content')

.head-div
  .avatar-div
    - if ($user)
      %img.avatar-icon{src: $user->wx ? json_decode($user->wx)->headimgurl : "icon/avatar.png"}
      %p.name.f16.color7= str_limit($user['name'], $limit = 24, $end = '...')
    .right-div
      %span.f12.color5 个人资料
      %img.arrow{src: "icon/go.png"}
  %img.message-icon{src: "icon/message.png"}
  - if ($messagesCount)
    %img.small-circle{src: "icon/small-dot.png"}
%hr.div-line
- if (count($onGoingCourses) == 0 && count($enrolledCourses) == 0 && count($favoritedCourses) == 0)
  .empty-div
    %img.empty-icon{src: "icon/empty.png"}
    %p.empty-message.f12.color5 您还没有相关课程信息......
- else
  - if (count($onGoingCourses) > 0)
    .course-div
      %p.f14.color7.fb.mb28.title 待参加课程
      - foreach ($onGoingCourses as $onGoingCourse)
        .item{'data-id' => $onGoingCourse['id']}
          .item-left
            .category-class.f12.fb= $onGoingCourse['category']['name']
            %p.course-name.f16.color7= str_limit($onGoingCourse['name'], $limit = 24, $end = '...')
            .row-divf.f12.color6
              %span 时间：
              %span= $onGoingCourse['time']
            .row-div.f12.color6
              %span.address-span 地址：
              %span.address= $onGoingCourse['name']
          .item-right
            %img.signin{src: "icon/signin.png"}
    %hr.div-line
  - if (count($enrolledCourses) > 0)
    .course-div.enrolled-course
      .title-div.clearfix
        %span.f14.color7.fb.mb12 我的课程
        %span.course-more.f10.color5.fr 更多
      - foreach ($enrolledCourses as $enrolledCourse)
        .favorite-item{'data-id' => $enrolledCourse['id']}
          .icon-div
            %img.icon{src: $enrolledCourse['cover'] ? strpos($enrolledCourse['cover'], '/') == 0 ? substr($enrolledCourse['cover'],1) :$enrolledCourse['cover'] : "icon/example.png"}
          .word-div
            .favorite-row-div.clearfix
              %span.category-class.f12= $enrolledCourse['category']['name']
              %span.item-value.f14.color5= "￥".($enrolledCourse['price'] ? $enrolledCourse['price'] : $enrolledCourse['original_price'])
            .favorite-row-div.color7.unstart
              %span.favorite-name.f16= str_limit($enrolledCourse['name'], $limit = 24, $end = '...')
              - if ($enrolledCourse['type'] == 'offline')
                %span.course-status.f8 线下
            .favorite-row-div.f12.color6
              - if ($enrolledCourse['type'] == 'offline')
                %span.participate= $enrolledCourse['users_count']."人已报名"
                %span .
                %span= date_format(date_create($enrolledCourse['begin']),"m月/d日")."开课"
              - else 
                %span.participate= $enrolledCourse['users_count']."人已学"
                %span .
                %span= $enrolledCourse['comments_count'] ."条评论"
    .hr.div-line
  - if (count($favoritedCourses) > 0)
    .course-div.favorite-div
      .title-div.clearfix
        %span.f14.color7.fb.mb12 我的收藏
        %span.favorite-more.f10.color5.fr 更多
      - foreach ($favoritedCourses as $favoritedCourse)
        .favorite-item{'data-id' => $favoritedCourse['id']}
          .icon-div
            %img.icon{src: $favoritedCourse['cover'] ? strpos($favoritedCourse['cover'], '/') == 0 ? substr($favoritedCourse['cover'],1) :$favoritedCourse['cover'] : "icon/example.png"}
          .word-div
            .favorite-row-div.clearfix
              %span.category-class.f12= $favoritedCourse['category']['name']
              %span.item-value.f14.color5= "￥".($favoritedCourse['price'] ? $favoritedCourse['price'] : $favoritedCourse['original_price'])
            .favorite-row-div.color7.unstart
              %span.favorite-name.f16= str_limit($favoritedCourse['name'], $limit = 24, $end = '...')
              - if ($favoritedCourse['type'] == 'offline')
                %span.course-status.f8 线下
            .favorite-row-div.f12.color6
              - if ($favoritedCourse['type'] == 'offline')
                %span.participate= $favoritedCourse['users_count']."人已报名"
                %span .
                %span= date_format(date_create($favoritedCourse['begin']),"m月/d日")."开课"
              - else
                %span.participate= $favoritedCourse['users_count']."人已学"
                %span .
                %span= $favoritedCourse['comments_count'] ."条评论"
.foot
  .foot-item-div#home
    %img.home{src: "icon/home_normal.png"}
    %p.f10.color5 首页
  .foot-item-div#mine
    %img.mine{src: "icon/mine_selected.png"}
    %p.f10.color8.fb 我的

@endsection

@section('script')
<script src= "{{ mix('/js/mine-index.js') }}"></script>
<script src= "js/course_index.js"></script>
@endsection