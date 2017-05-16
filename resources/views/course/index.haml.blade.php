@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/course-index.css') }}">

@endsection

@section('content')
.search-div.f12
  %img.search{src: '/icon/search.png'}
  %input.search-input.color5{type: "text", placeholder: "搜索课程名/老师名"}
.nav-div
  %ul.nav.f14
    %li.active
      %a#feed{:href => "#"} 新课速递
    %li
      %a#health{:href => "#"} 健康教育
    %li
      %a#psychology{:href => "#"} 心理教育
    %li
      %a#grow{:href => "#"} 自我成长
.img_gallery
  .point
    %a{:href => "#"} 1
    %a{:href => "#"} 2
    %a{:href => "#"} 3
  .main_img
    %ul
      %li
        %a{:href => "#"}
          %img.img_1{src: '/icon/banner.png'}
      %li
        %a{:href => "#"}
          %img.img_2{src: '/icon/banner.png'}
      %li
        %a{:href => "#"}
          %img.img_3{src: '/icon/banner.png'}
    %a#btn_prev{:href => "#"}
    %a#btn_next{:href => "#"}

@endsection

@section('script')
<scrip src= "/js/jquery.min.js"></scrip>

<script src= "/js/jquery.touchSlider.js"></script>
<script src= "/js/jquery.event.drag.js"></script>
<script src="{{ mix('/js/course-index.js') }}"></script>
@endsection


