@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/course-show.css') }}">
:javascript
  window.sms_send = "#{route('sms.send')}"
  window.sms_verify = "#{route('sms.verify')}"
  window.user_profile = "#{route('user.profile')}"
  window.token = "#{csrf_token()}"
  window.course_item="#{route('index')}"
  window.favorite = "#{route('courses.favorite',$course['id'])}"
  window.review = "#{route('comments.store')}"
  window.order = "#{route('orders.pay')}"
  window.pay_finish = "#{route('orders.finish')}"
  window.refund = "#{route('orders.refund',-1)}"
  window.validmobile = "#{route('validate.phone')}"
  window.review = "#{route('courses.comments.index',$course->id)}"
  window.comment_id = "#{route('comments.vote', -1)}"

@endsection
@section('content')
.head-div
  %img.course-photo{src: $course['cover'] ? $course['cover'] : "icon/course.png"}
  %img.back{src: "icon/back2.png"}
  - if ($hasFavorited == true)
    %img.favorite{src: "icon/like_selected.png", 'data-fav'=> "true"}
  - else
    %img.favorite{src: "icon/like_normal.png", 'data-fav'=> "false"}
  .course-title-div
    .course-row-div.clearfix
      %span.f12.category-class= $course['category_id']
    .course-row-div.color7.status-flex
      %span.name-span.f16.fb.color7= $course['name']
      %span.course-id{style: "display:none;"}= $course['id']
      - if ($course['type'] == "offline")
        %span.course-status.f8 线下
    - if($course['type'] == "online")
      .btn#test-btn{type: "button"}
        %img.play{src: "icon/play.png"}
        - if ($hasEnrolled == true )
          %span 立即听课
        - else
          %span 立即试课
.desc-div
  .common-div
    - if ($hasEnrolled == false)
      %span.price-pay.f16.fb.color11= $course['price'] ? "￥". $course['price'] : "￥".$course['original_price']
      - if($course['price'])
        %span.price.f12.color6= "￥". $course['original_price']
      - if ($course['type'] == "offline")
        %span.f12.color5= $enrolledCount."人已报名"."(限30人)"
      - else
        %span.f12.color5= $enrolledCount."人已报名"
    - else
      %span.f12.color6.mr40 已报名
      - if ($course['type'] == "offline")
        %span.f12.color5= $enrolledCount."人已报名"."(限30人)"
      - else
        %span.f12.color5= $enrolledCount."人已报名"
  // underline course
  - if ($course['type'] == "offline")
    .unonline-div
      .unonline-row.f14.color7
        %span 时间：
        %span= $course['time']
      .unonline-row.f14.color7
        %span.address-span 地址：
        %span.address= $course['address']
%hr.div-line
// underline course
- if ($course['type'] == "offline")
  .course-content.clearfix
    %span.title.f14.color7.fb 课时情况
    - if ($hasEnrolled == true)
      %span.refund.f12.color5 退款
      - if(!empty($order))
        %span.uuid{style: "display:none;"}= $order->uuid
    .items-div.offline-lesson
      - for ($i=0;$i<count($lessons);$i++)
        .item.opt55{"data-id" => $lessons[$i]['id']}
          %p.num-div.f16.color7= ($i + 1)
          .item-desc
            %p.f14.color7= $lessons[$i]['name']
            .item-row.f12.color5
              %span.min= date_format(date_create($lessons[$i]['begin']),"Y/m/d")
              %span= date_format(date_create($lessons[$i]['begin']),"H:i")."~".date_format(date_create($lessons[$i]['end']),"H:i")
          - if ($lessons[$i]['hasAttended'])
            %img.sign-icon{src: "icon/arrive.png"}
          - else
            %img.sign-icon{src: "icon/absent.png"}
      - if (count($lessons) > 3)
        .view-more
          %span.f12.color5 查看更多
          %img.more-icon{src: "icon/more.png"}
  %hr.div-line
- else
  .course-content
    %span.title.f14.color7.fb 课程目录
    - if (count($lessons) > 3)
      %span.f12.color7= "(共".count($lessons)."节)"
    .items-div.online-course
      - for ($i=0;$i<count($lessons);$i++)
        %a.item{"data-id" => $lessons[$i]['id'], "data-status" => $lessons[$i]['status'], href: route("courses.lessons.show", ['course'=>$course,'lesson'=>$lessons[$i]])}
          %span.hasenrolled{style: "display:none;"}= $hasEnrolled
          %p.num-div.f16.color7= ($i + 1)
          - if ($lessons[$i]['status'] == 'publish')
            .item-desc
              %p.f14.color7= $lessons[$i]['name']
              .item-row.f12.color5
                %span.min.course-time{"time-end" => $lessons[$i]['end']}= $lessons[$i]['begin'] ? $lessons[$i]['begin'] : "无时间"
                %span= $lessons[$i]->learnedCount."人已学"
            %img.go{src: "icon/go.png"}
            %img.free{src: "icon/free.png"}
          - else
            .item-desc
              %p.f14.color7= $lessons[$i]['name']
              .item-row.f12.color5
                %span 未上线
      - if (count($lessons) > 3)
        .view-more
          %span.f12.color5 查看更多
          %img.more-icon{src: "icon/more.png"}
  %hr.div-line
.course-content
  %span.title.f14.color7.fb 授课老师
  - if ($course['type'] == "online")
    %span.f12.color7= "(共".count($teachers)."位)"
  .items-div
    - foreach ($teachers as $teacher)
      %a.teacher-item{href: route('users.show', $teacher['id'])}
        %img.avatar{src: $teacher['avatar'] ? $teacher['avatar'] : "icon/avatar.png"}
        .item-desc
          %p.f14.color7.teacher-name= $teacher['name']."老师"
          .f12.color6!= json_decode($teacher['description'])->basicIntroduction
    - if (count($teachers) > 3)
      .view-more
        %span.f12.color5 查看更多
        %img.more-icon{src: "icon/more.png"}
%hr.div-line
.course-desc
  %span.f14.color7.fb 课程介绍
  .desc-box.f12.color7!= $course['description']
%hr.div-line
.recommend-div
  %span.recommend-title.f14.color7.fb 推荐课程
  - foreach ($recommendedCourses as $recommendedCourse)
    .course-item{"data-id" => $recommendedCourse['id']}
      .course-icon-div
        %img.course-icon{src: $recommendedCourse['cover'] ? $recommendedCourse['cover'] : "icon/example.png"}
      .word-div
        .course-row-div.clearfix
          %span.f12.category-class= $recommendedCourse['category']['name']
          %span.course-item-value.f14.color5= $recommendedCourse['price'] ? "￥". $recommendedCourse['price'] :"无"
        .course-row-div.color7.unstart
          %span.name-span.f16= $recommendedCourse['name']
          - if ($recommendedCourse['type'] == 'offline')
            %span.course-status.f8 线下
        .course-row-div.f12.color6
          - if ($recommendedCourse['type'] == 'offline')
            %span.participate= $recommendedCourse['users_count']."人已报名"
            %span .
            %span= date_format(date_create($recommendedCourse['begin']),"m月/d日") ."开课"
          - else
            %span.participate= $recommendedCourse['users_count']."人已学"
            %span .
            %span= $recommendedCourse['comments_count'] ."条评论"
- if ($course['type'] == "online")
  %hr.div-line
// 线下课程不显示评论
- if ($course['type'] == "online")
  - if (count($comments) > 3)
    .course-content
      .review-title
        %span.title.f14.color7.fb 课程评论
        %span.f12.color7= "(共".$comments->total()."条)"
        %p.review-score.f12.color5= $avgRate."分/".count($comments)."人已评"
      .review-items-div
        - foreach ($comments as $comment)
          .review-item{"data-url" => route("comments.vote", $comment['id'])}
            %img.review-avatar{src: $comment->user->avatar ? $comment->user->avatar : "icon/avatar.png"}
            .item-desc
              %p.f12.color7.review-name= $comment->user->name
              %p.f12.color5.time= $comment['created_at']
              %p.f14.color7.review-content= $comment['content']
              %span.f12.color5 评论来源：
              %span.f12.color5= $comment->lesson->name
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
            %span.f12.color5 评论来源：
            %span.f12.color5= $latestComment->lesson->name
            .admire-div
              %span.f12.color5.admire-num= $latestComment['voteCount']
              - if ($latestComment['hasVoted'] == false)
                %img.admire-icon{src: "icon/like1_normal.png", 'data-ad'=> 'false'}
              - else
                %img.admire-icon{src: "icon/like1_selected.png", 'data-ad'=> 'true'}
  - else
    .course-content
      .review-title
        %span.title.f14.color7.fb 课程评论
        %span.f12.color7= "(共".$comments->total()."条)"
        %p.review-score.f12.color5= count($comments) > 0 ? $avgRate."分/".count($comments)."人已评" : "5分/1人已评"
      .review-items-div
        - foreach ($comments as $comment)
          .review-item{"data-url" => route("comments.vote", $comment['id'])}
            %img.review-avatar{src: $comment->user->avatar ? $comment->user->avatar : "icon/avatar.png"}
            .item-desc
              %p.f12.color7.review-name= $comment->user->name
              %p.f12.color5.time= $comment['created_at']
              %p.f14.color7.review-content= $comment['content']
              %span.f12.color5 评论来源：
              %span.f12.color5= $comment->lesson->name
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
- if ($hasEnrolled == true)
  - if ($course['type'] == "online")
    .btn#review-btn{type: "button"} 评价课程
  - else
    .btn#sign-btn{type: "button"} 课程签到
- else
  .btn#add-btn{type: "button"} 立即报名

@endsection

@section('modal-div')
#confirmModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"}
  .modal-dialog
    .modal-content
      .modal-body
        %p.prompt 未报名课程
        %p.question　确认立即报名当前课程？
        .confirm-div
          %a#register 报名
          %a{"data-dismiss" => "modal"} 取消

#reviewModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"}
  .modal-dialog
    .modal-content
      .modal-body
        .course-review-div
          %p.name.f14.color7= $course['name']."这门课您认为可以打几星呢？"
          %p.star-div
            %input{:checked => "checked", :name => "a", :type => "radio", :value => "0"}
            %input{:name => "a", :type => "radio", :value => "1"}
            %input{:name => "a", :type => "radio", :value => "2"}
            %input{:name => "a", :type => "radio", :value => "3"}
            %input{:name => "a", :type => "radio", :value => "4"}
            %input{:name => "a", :type => "radio", :value => "5"}
        %button#review-submit{type: "button"} 提交评价
#profileModal.modal.fade.bottom{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"}
  .modal-dialog
    .modal-content
      .modal-body
        .height-div
          .head-div
            %p.fb.tc.fb.color7.f18 个人资料
            %img.profile-close{src: "icon/close.png"}
          .item-div
            .item
              .left-div
                %img.avatar{src: "icon/avatar.png"}
              .right-div
                .row-div
                  %label.f14.color7.fn 家长身份
                  %select.input-div#parent
                    %option{value: "请选择"} 请选择
                    %option{value: "爸爸"} 爸爸
                    %option{value: "妈妈", selected: "selected"} 妈妈
                .row-div
                  %label.f14.color7.fn 手机号码
                  .mobile-div
                    %input.f12.color6#mobile
                    %button.f12.color10#code 发送验证码
                .row-div
                  %label.f14.color7.fn 验证码
                  %input.input-div.f12.color6#mobile-code
            .baby-item.item-baby-div
              .left-div
                %img.avatar{src: "icon/baby_female.png"}
              .right-div
                .row-div
                  %label.f14.color7.fn 宝宝姓名
                  %input.input-div#baby-name.baby-name
                .row-div
                  %label.f14.color7.fn 宝宝性别
                  %select.input-div.gender#baby-gender
                    %option{value: "请选择"} 请选择
                    %option{value: "男子汉"} 男子汉
                    %option{value: "小姑娘"} 小姑娘
                .row-div
                  %label.f14.color7.fn 宝宝生日
                  %input.input-div#baby-birthday.birthday{type: "date"}

            .baby-item.add-baby-div
              %img.close-add-item{src: "icon/close.png"}
              .left-div
                %img.avatar{src: "icon/baby_female.png"}
              .right-div
                .row-div
                  %label.f14.color7.fn 宝宝姓名
                  %input.add-input-div#add-baby-name.baby-name
                .row-div
                  %label.f14.color7.fn 宝宝性别
                  %select.add-input-div.add-gender.gender#add-baby-gender
                    %option{value: "请选择"} 请选择
                    %option{value: "男子汉"} 男子汉
                    %option{value: "小姑娘"} 小姑娘
                .row-div
                  %label.f14.color7.fn 宝宝生日
                  %input.add-input-div.birthday#add-baby-birthday{type: "date"}
            %p.f12.color10.pt16#another-baby 还有一个宝宝?
          .btn#edit-end 编辑完成
@endsection

@section('script')
<script src= "{{ mix('/js/course-show.js') }}"></script>
<script src= "js/review-modal.js"></script>

@endsection