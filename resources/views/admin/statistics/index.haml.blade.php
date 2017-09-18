@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_current_data.css') }}">

// :javascript
//     window.lesson_index = "#{route('lessons.index')}"
//     window.lesson_store = "#{route('lessons.store')}"
//     window.video = "#{route('videos.store')}"
//     window.token = "#{csrf_token()}"
//     window.client_index = "#{route('users.index')}"
@endsection

@section('content')
    
.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li.active
          %a.f16.font-color1 当前数据
        %li
          %a.f16.font-color1 用户统计
        %li
          %a.f16.font-color1 金额统计
        %li
          %a.f16.font-color1 课程统计
      .tab-content.bg3
        #tab1.tab-pane.active
          .desc-div

@endsection

@section('script')
// <script src= "{{mix('/js/admin_client_index.js')}}"></script>


@endsection