@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/message.css') }}">

@endsection
@section('content')
.head-div
  %p.fb.tc.fb.color7.f18 消息
  %img.back{src: "/icon/back.png"}
  %hr.div-line
- if (count($messages) > 0)
  .message-item-div
    - foreach ($messages as $message)
      - if ($message['from'])
        .item-review
          .avatar-div
            %img.avatar{src: $message->comment->user['avatar'] ? $message->comment->user['avatar'] : "/icon/avatar.png"}
          .desc-div
            %p.name.f12.color7= $message->comment->user['name']
            %p.time.f12.color5= $message->comment['created_at']
            %p.num.f14.color7= "等".$message['num']."人赞了您的评论"
            %p.notice.f14.color5= $message->comment['content']
      - else
        .item-notice
          .avatar-div
            %img.avatar{src: "/icon/ma_icon.png"}
          .desc-div
            %p.name.f12.color7 课程小助手
            %p.time.f12.color5= $message['created_at']
            %p.num.f14.color7= $message['content']
- else
  .empty-div
    %img.empty-icon{src: "/icon/empty.png"}
    %p.empty-message.f12.color5 您还没有相关消息......

@endsection


@section('script')
<script src= "{{ mix('/js/message.js') }}"></script>
@endsection