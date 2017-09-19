@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_statistics_index.css') }}">

@endsection

@section('content')
    
.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li
          %a.f16.font-color1#current-data{href: route('statistics.index')} 当前数据
        %li
          %a.f16.font-color1#client{href: route('statistics.user')} 用户统计
        %li.active
          %a.f16.font-color1#amount 金额统计
        %li
          %a.f16.font-color1#course-statistics{href: route('courses.statistics')} 课程统计
      .tab-content.bg3
        #tab1.tab-pane.active
          .desc-div
            
@endsection

@section('script')

@endsection