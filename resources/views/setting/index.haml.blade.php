@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/setting-index.css') }}">

@endsection
@section('content')
.head-div
  %p.fb.tc.fb.color7.f18 个人资料
  %img.back{src: "/icon/back.png"}
.item-div 
  .item
    .left-div
      %img.avatar{src: "/icon/avatar.png"}
    .right-div
      .row-div
        %label.f14.color7.fn 微信名称
        %span.f12.color6.span-desc 限制十四个字
        %input.input-div
      .row-div
        %label.f14.color7.fn 家长身份
        %span.f12.color6.span-desc 妈妈
        %input.input-div
      .row-div
        %label.f14.color7.fn 手机号码
        %span.f12.color6.span-desc 13011111111
        %input.input-div
      .row-div
        %a.edit 编辑

@endsection

@section('script')
<script src= "{{ mix('/js/setting-index.js') }}"></script>
@endsection