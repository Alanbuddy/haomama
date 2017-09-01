@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/creview.css') }}">
:javascript
  window.enroll = "#{$hasEnrolled}"
  window.course = "#{route('courses.show',$course)}"
  window.behavior = "#{route('behaviors.store')}" 
  window.video_id = "#{$video['id']}"
  window.token = "#{csrf_token()}"
  window.comment = "#{route('comments.store')}"
  window.order = "#{route('orders.pay')}"
  window.comment_id = "#{route('comments.vote', -1)}"
  window.upload_review = "#{route('courses.lesson.comments',compact('course','lesson'))}"
@endsection
@section('content')
.head-div
  %img.back{src: "icon/back2.png"}
  - if($lesson->type == "video")
    %p.file-id= empty($video) ? -1 : $video->cloud_file_id
    .video-div#id_video_container{style: "width:100%;height:auto;"}
  - else
    %p.file-id= empty($audio) ? -1 : $audio->cloud_file_id
    .audio-div
      %img.audio-poster{src:count($pictures)? strpos($pictures[0]->path, '/') == 0 ? substr($pictures[0]->path, 1) : $pictures[0]->path:''}
      %audio.panel#audio{:controls => "", src: strpos($audio->path, '/') == 0 ? substr($audio->path, 1) : $audio->path}
    .pictures{style: "display:none;"}
      - foreach($pictures as $picture)
        .picture-item
          %span.picture= strpos($picture->path, '/') == 0 ? substr($picture->path, 1) : $picture->path
          %span.picture-time= $picture->pivot->no
%ul.nav
  %li.active 详情
  %li 评论
.main-div{style: "display:block"}
  .title-div
    .row-div.clearfix
      %span.name.f18.color7.fb.lesson-id{"data-id" => $lesson['id']}= $lesson['name']
      %span.num.f12.color5= $learnedCount."人已学"
    %p.f14.color6.course-id{"data-id" => $course['id']}= $course['name']."-第".($index + 1)."课"
  .div-line
  .dir-div
    %span.title.f14.color7.fb 课程目录
    .nums-div
      - for ($i=0;$i<count($lessons);$i++)
        %a.common{"data-status" => $lessons[$i]['status'], "data-newest" => $lessons[$i]['isNewest'], "data-index" => $index, href: route("courses.lessons.show", ['course'=>$course,'lesson'=>$lessons[$i]])}
          %span= ($i + 1)
  .div-line
  .desc-div.f14.color7
    %span.fb 本课内容
    .desc!= $lesson['description']

.main-div
  - if (count($latestComments) > 3)
    .hot-review-div
      .review-title
        %span.title.f14.color7.fb 课程评论
        %span.f12.color7= "(共".$comments->total()."条)"
      .review-items-div
        - foreach ($comments as $comment)
          .review-item{"data-url" => route("comments.vote", $comment['id'])}
            %img.review-avatar{src: $comment->user->avatar ? $comment->user->avatar : "icon/avatar.png"}
            .item-desc
              %p.f12.color7.review-name= $comment->user->name
              %p.f12.color5.time= $comment['created_at']
              %p.f14.color7.review-content= $comment['content']
              // %span.f12.color5 评论来源：
              // %span.f12.color5= $comment->lesson->name
              .admire-div
                %span.f12.color5.admire-num= $comment['voteCount']
                - if ($comment['hasVoted'] == false)
                  %img.admire-icon{src: "icon/like1_normal.png", 'data-ad'=> 'false'}
                - else
                  %img.admire-icon{src: "icon/like1_selected.png", 'data-ad'=> 'true'}
    %p.f12.color6.feed-review 最新评论
    .feed-review-items-div
      - foreach ($latestComments as $latestComment)
        .review-item{"data-url" => route("comments.vote", $latestComment['id'])}
          %img.review-avatar{src: $latestComment->user->avatar ? $latestComment->user->avatar : "icon/avatar.png"}
          .item-desc
            %p.f12.color7.review-name= $latestComment->user->name
            %p.f12.color5.time= $latestComment['created_at']
            %p.f14.color7.review-content= $latestComment['content']
            // %span.f12.color5 评论来源：
            // %span.f12.color5= $latestComment->lesson->name
            .admire-div
              %span.f12.color5.admire-num= $latestComment['voteCount']
              - if ($latestComment['hasVoted'] == false)
                %img.admire-icon{src: "icon/like1_normal.png", 'data-ad'=> 'false'}
              - else
                %img.admire-icon{src: "icon/like1_selected.png", 'data-ad'=> 'true'}
      .load
        %img.loading{src: "icon/loading.gif"}
        %span.notice.f12 亲没数据了～
  - else
    .hot-review-div
      .review-title
        %span.title.f14.color7.fb 课程评论
        %span.f12.color7= "(共".$comments->total()."条)"
      .review-items-div
        - if(count($comments) == 0)
          .undiscover
            %img.undiscover-icon{src: "icon/admin/undiscover.png"}
        - else
          - foreach ($comments as $comment)
            .review-item{"data-url" => route("comments.vote", $comment['id'])}
              %img.review-avatar{src: $comment->user->avatar ? $comment->user->avatar : "icon/avatar.png"}
              .item-desc
                %p.f12.color7.review-name= $comment->user->name
                %p.f12.color5.time= $comment['created_at']
                %p.f14.color7.review-content= $comment['content']
                // %span.f12.color5 评论来源：
                // %span.f12.color5= $comment->lesson->name
                .admire-div
                  %span.f12.color5.admire-num= $comment['voteCount']
                  - if ($comment['hasVoted'] == false)
                    %img.admire-icon{src: "icon/like1_normal.png", 'data-ad'=> 'false'}
                  - else
                    %img.admire-icon{src: "icon/like1_selected.png", 'data-ad'=> 'true'}
          .load
            %img.loading{src: "icon/loading.gif"}
            %span.notice.f12 亲没数据了～
%img.upper{src: "icon/top.png"}
@endsection
@section('foot-div')
- if ($hasEnrolled)
  .foot-div
    %input.review-input{placeholder: "写评论......"}
    .btn#delivery 发送
@endsection

@section('modal-div')
#confirmModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modal-body
        %p.prompt 您还未报名该课程,请到课程页面进行报名～!
        // %p.question　
        // .confirm-div
        //   %a#register 报名
        //   %a{"data-dismiss" => "modal"} 取消
@endsection

      
@section('script')
<script src="https://qzonestyle.gtimg.cn/open/qcloud/video/h5/h5connect.js" charset="utf-8"></script>
<script src= "{{ mix('/js/creview.js') }}"></script>
<script src= "js/prompt.js"></script>
- if ($lesson->type == "video")
  <script src= "js/video-play.js"></script>
- else
  <script src= "js/audio-play.js"></script>

@endsection