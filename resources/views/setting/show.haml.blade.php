@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/pay-success.css') }}">

@endsection

@section('content')
.sign-div
  %img.success-icon{src: "/icon/success.png"}
  %p.f16.color7 退款成功
  .name-div.f12.color6
    %span 课程
    %span 课程名称很长很长
.btn#view.mt80 查看详情
.sign-div
  %img.success-icon{src: "/icon/success.png"}
  %p.f16.color7 完成报名
  .name-div.f12.color6
    %span 课程
    %span 课程名称很长很长
.btn#view.mt80 查看详情

@endsection

@section('script')
<script src= "{{ mix('/js/pay-success.js') }}"></script>
@endsection