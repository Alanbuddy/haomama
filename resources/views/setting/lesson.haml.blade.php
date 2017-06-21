@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/creview.css') }}">

@endsection
@section('content')
.head-div
  %img.back{src: "/icon/back2.png"}
  %img.course-photo{src: "/icon/course.png"}
%ul.nav
  %li.active 详情
  %li 评论
.main-div{style: "display:block"}
  .title-div
    .row-div.clearfix
      %span.name.f18.color7.fb= $lesson['name']
      %span.num.f12.color5 1113人已学
    %p.f14.color6= $course['name']."-第"."课"
  .div-line
  .dir-div
    %span.title.f14.color7.fb 课程目录
    .nums-div{"data-enroll" => $hasEnrolled}
      - for ($i=0;$i<count($lessons);$i++)
        %a.common{"data-status" => $lessons[$i]['status']}
          %span= ($i + 1)
  .div-line
  .desc-div.f14.color7
    %span.fb 本课内容
    .desc= $lesson['description']

.main-div
  - if (count($comments) > 3)
    .hot-review-div
      .review-title
        %span.title.f14.color7.fb 课程评论
        %span.f12.color7= "(共".$comments->total()."条)"
      .review-items-div
        - foreach ($comments as $comment)
          .review-item{"data-url" => route("comments.vote", $comment['id'])}
            %img.review-avatar{src: $comment->user->avatar ? $comment->user->avatar : "/icon/avatar.png"}
            .item-desc
              %p.f12.color7.review-name= $comment->user->name
              %p.f12.color5= (strtotime(time()) - strtotime($comment['created_at']))."天前"
              %p.f14.color7.review-content= $comment['content']
              %span.f12.color5 评论来源：
              %span.f12.color5= $comment->lesson->name
              .admire-div
                %span.f12.color5.admire-num= $comment['voteCount']
                - if ($comment['hasVoted'] == false)
                  %img.admire-icon{src: "/icon/like1_normal.png", 'data-ad'=> 'false'}
                - else
                  %img.admire-icon{src: "/icon/like1_selected.png", 'data-ad'=> 'true'}
    %p.f12.color6.feed-review 最新评论
    .feed-review-items-div
      - foreach ($latestComments as $latestComment)
        .review-item{"data-url" => route("comments.vote", $latestComment['id'])}
          %img.review-avatar{src: $latestComment->user->avatar ? $latestComment->user->avatar : "/icon/avatar.png"}
          .item-desc
            %p.f12.color7.review-name= $latestComment->user->name
            %p.f12.color5= (strtotime(time()) - strtotime($latestComment['created_at']))."天前"
            %p.f14.color7.review-content= $latestComment['content']
            %span.f12.color5 评论来源：
            %span.f12.color5= $latestComment->lesson->name
            .admire-div
              %span.f12.color5.admire-num= $latestComment['voteCount']
              - if ($latestComment['hasVoted'] == false)
                %img.admire-icon{src: "/icon/like1_normal.png", 'data-ad'=> 'false'}
              - else
                %img.admire-icon{src: "/icon/like1_selected.png", 'data-ad'=> 'true'}
  - else
    .hot-review-div
      .review-title
        %span.title.f14.color7.fb 课程评论
        %span.f12.color7= "(共".$comments->total()."条)"
      .review-items-div
        - foreach ($comments as $comment)
          .review-item{"data-url" => route("comments.vote", $comment['id'])}
            %img.review-avatar{src: $comment->user->avatar ? $comment->user->avatar : "/icon/avatar.png"}
            .item-desc
              %p.f12.color7.review-name= $comment->user->name
              %p.f12.color5= (strtotime(time()) - strtotime($comment['created_at']))."天前"
              %p.f14.color7.review-content= $comment['content']
              %span.f12.color5 评论来源：
              %span.f12.color5= $comment->lesson->name
              .admire-div
                %span.f12.color5.admire-num= $comment['voteCount']
                - if ($comment['hasVoted'] == false)
                  %img.admire-icon{src: "/icon/like1_normal.png", 'data-ad'=> 'false'}
                - else
                  %img.admire-icon{src: "/icon/like1_selected.png", 'data-ad'=> 'true'}
@endsection
@section('foot-div')
//未购买时不显示底部评论input
.foot-div
  %input.review-input{placeholder: "写评论......"}
  .btn#delivery 发送
@endsection
#confirmModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modal-body
        %p.prompt 未报名课程
        %p.question　确认立即报名当前课程？
        .confirm-div
          %a#register 报名
          %a{"data-dismiss" => "modal"} 取消
      


@section('script')
<script src= "{{ mix('/js/creview.js') }}"></script>
<script src= "/js/prompt.js"></script>
@endsection