@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/course-create.css') }}">
:javascript
  window.home = "#{route('index')}"
  window.course_search="#{route('courses.search')}"

@endsection

@section('content')
.search-box.clearfix
  %img.back.fl{src: "icon/back.png"}
  .input-div
    %input.input-box.f14.color7
    %img.search-icon{src: "icon/search.png"}
  .search-auto
    %span.f12.color5 热搜推荐
    - foreach ($popularTags as $popularTag)
      %a.f14.color7.tag-word{href: route('tag',$popularTag->id)}= $popularTag->name

@endsection

@section('script')
<script src= "{{ mix('/js/course-create.js') }}"></script>
@endsection