@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/message.css') }}">

@endsection
@section('content')
.head-div
  %p.fb.tc.fb.color7.f18 消息
  %img.back{src: "/icon/back.png"}
  %hr.div-line
.empty-div
  %img.empty-icon{src: "/icon/empty.png"}
  %p.empty-message.f12.color5 您还没有相关消息......
.message-item-div
  .item-review
    .avatar-div
      %img.avatar{src: "/icon/avatar.png"}
    .desc-div
      %p.name.f12.color7 路人甲
      %p.time.f12.color5 三天前
      %p.num.f14.color7 等9人赞了您的评论
      %p.notice.f14.color5 "本课程提供重要知识点备忘课件，课件下载地址为：......."
  .item-notice
    .avatar-div
      %img.avatar{src: "/icon/avatar.png"}
    .desc-div
      %p.name.f12.color7 课程小助手
      %p.time.f12.color5 三天前
      %p.num.f14.color7 您报名的课程"名字很长很长的"已有更新～请尽快学习～

@endsection


@section('script')
<script src= "{{ mix('/js/message.js') }}"></script>
@endsection