@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/course-create.css') }}">
:javascript
  window.home = "#{route('index')}"

@endsection

@section('content')
.search-box.clearfix
  %img.back.fl{src: "/icon/back.png"}
  .input-div
    %input.input-box.f14.color7
    %img.search-icon{src: "/icon/search.png"}
  .search-auto
    %span.f12.color5 热搜推荐
    %p.f14.color7.tag-word 标签词

@endsection

@section('script')
<script src= "{{ mix('/js/course-create.js') }}"></script>
@endsection