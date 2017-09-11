@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/sign.css') }}">
:javascript
  window.course_item="#{route('courses.index')}"

@endsection

@section('content')
- if (!$hasEnrolled)
  .sign-div
    %img.fail-icon{src: "icon/fail.png"}
    %p.f16.color7 签到失败
    %p.reason.f12.color6 您尚未报名该课程!
  .btn#scan 重新扫描
- else 
  .sign-div
    %img.success-icon{src: "icon/success.png"}
    %p.f16.color7 签到成功
    .name-div.f12.color6
      %span 课程
      %span= $course['name']
    %p.f12.color6= "第".($index+1)."次课已签到成功～"
  .btn#view.mt80{"data-id" => $course['id']} 查看详情

@endsection

@section('script')
<script src= "{{ mix('/js/sign.js') }}"></script>
@endsection