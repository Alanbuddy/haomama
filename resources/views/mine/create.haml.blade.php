@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/sign.css') }}">

@endsection

@section('content')
.sign-div
  %img.fail-icon{src: "/icon/fail.png"}
  %p.f16.color7 签到失败
  %p.reason.f12.color6 您尚未报名该课程!
  // %p.reason.f12.color6 这不是课程二维码!
  // %p.reason.f12.color6 您已签到该次课程!
.btn#scan 重新扫描
.sign-div
  %img.success-icon{src: "/icon/success.png"}
  %p.f16.color7 签到成功
  .name-div.f12.color6
    %span 课程
    %span 课程名称很长很长
  %p.f12.color6 第三次课已签到成功～
.btn#view.mt80 查看详情


@endsection

@section('script')
<script src= "{{ mix('/js/sign.js') }}"></script>
@endsection