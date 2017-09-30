@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/pay-success.css') }}">

@endsection

@section('content')
.sign-div
  %img.success-icon{src: "icon/success.png"}
  %p.f16.color7 退款成功
  .name-div.f12.color6
    %span 课程
    %span= $course->name
    %span.course-id{style: "display:none;"}= $course->id

.btn#view.mt80 查看详情

@endsection

@section('script')
<script src= "{{ mix('/js/pay-success.js') }}"></script>
@endsection