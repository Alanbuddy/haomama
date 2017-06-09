@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/course-show.css') }}">

@endsection
@section('content')
.head-div
  %img.course-photo{src: "/icon/course.png"}
  %img.back{src: "/icon/back2.png"}
  // %img.favorite{src: "/icon/like_selected.png", 'data-fav'=> "false"}
  %img.favorite{src: "/icon/like_normal.png", 'data-fav'=> 'true'}
  .course-title-div
    .course-row-div.clearfix
      %span.health-title-small.f12 健康养育
    .course-row-div.color7.status-flex
      %span.name-span.f16.fb.color7 名字很长很长
      // 线下课程出现
      %span.course-status.f8 线下
    .btn#test-btn{type: "button"}
      %img.play{src: "/icon/play.png"}
      // 购买后变为立即听课
      %span 立即试课    
.desc-div
  .common-div
    // unpay
    %span.price-pay.f16.fb.color11 ¥200
    %span.price.f12.color6 ¥400
    %span.f12.color5 18人已报名
    //pay
    %span.f12.color6.mr40 已报名
    %span.f12.color5 18人已报名(限30人)
  // underline course
  .unonline-div
    .unonline-row.f14.color7
      %span 时间：
      %span 2017/05/20~2017/07/20
    .unonline-row.f14.color7
      %span.address-span 地址：
      %span.address 北京市朝阳区安立路北京市朝阳区安立路安立路北京市朝阳安立路北京市朝阳
%hr.div-line
// underline course
.course-content.clearfix
  %span.title.f14.color7.fb 课时情况
  //报名后会出现退款
  %span.refund.f12.color5 退款
  .items-div
    .item.opt55
      %p.num-div.f16.color7 1
      .item-desc
        %p.f14.color7 这是第一节线下课程的名字
        .item-row.f12.color5
          %span.min 2017/05/20
          %span 14:00~16:00
      //报名后会出现sign-icon，未报名不显示
      %img.sign-icon{src: "/icon/arrive.png"}
    .item.opt55
      %p.num-div.f16.color7 1
      .item-desc
        %p.f14.color7 这是第一节线下课程的名字
        .item-row.f12.color5
          %span.min 2017/05/20
          %span 14:00~16:00
      %img.sign-icon{src: "/icon/absent.png"}
    .item.opt55
      %p.num-div.f16.color7 1
      .item-desc
        %p.f14.color7 这是第一节线下课程的名字
        .item-row.f12.color5
          %span.min 2017/05/20
          %span 14:00~16:00
    // 三条以下不显示
    .view-more
      %span.f12.color5 查看更多
      %img.more-icon{src: "/icon/more.png"}
%hr.div-line
//online course
.course-content
  %span.title.f14.color7.fb 课程目录
  %span.f12.color7 (共8节)
  .items-div
    // 如果只有3条以下课程列表项，就去掉directory-div  unview-div, 隐藏view-more
    .fold-div   
      .unview-div
        .item
          %p.num-div.f16.color7 1
          .item-desc
            %p.f14.color7 宝宝生长发育特点
            .item-row.f12.color5
              %span.min 23min
              %span 1233人已学
          %img.go{src: "/icon/go.png"}
          %img.free{src: "/icon/free.png"}
        .item.opt55
          %p.num-div.f16.color7 1
          .item-desc
            %p.f14.color7 宝宝生长发育特点
            .item-row.f12.color5
              %span.min 23min
              %span 1233人已学
          %img.go{src: "/icon/go.png"}
        .item.opt55
          %p.num-div.f16.color7 1
          .item-desc
            %p.f14.color7 宝宝生长发育特点
            .item-row.f12.color5
              %span 未上线
        .item.opt55
          %p.num-div.f16.color7 1
          .item-desc
            %p.f14.color7 宝宝生长发育特点
            .item-row.f12.color5
              %span 未上线
        .item.opt55
          %p.num-div.f16.color7 1
          .item-desc
            %p.f14.color7 宝宝生长发育特点
            .item-row.f12.color5
              %span 未上线
        .item.opt55
          %p.num-div.f16.color7 1
          .item-desc
            %p.f14.color7 宝宝生长发育特点
            .item-row.f12.color5
              %span 未上线

    .view-more
      %span.f12.color5 查看更多
      %img.more-icon{src: "/icon/more.png"}
%hr.div-line
.course-content
  %span.title.f14.color7.fb 授课老师
  %span.f12.color7 (共5位)
  .items-div
    .teacher-fold-div
      .teacher-unview-div
        .teacher-item
          %img.avatar{src: "/icon/avatar.png"}
          .item-desc
            %p.f14.color7.teacher-name 王小明老师
            %p.f12.color6 这里写的是老师的简介信息，不能写太长
        .teacher-item
          %img.avatar{src: "/icon/avatar.png"}
          .item-desc
            %p.f14.color7.teacher-name 王小明老师
            %p.f12.color6 这里写的是老师的简介信息，不能写太长
        .teacher-item
          %img.avatar{src: "/icon/avatar.png"}
          .item-desc
            %p.f14.color7.teacher-name 王小明老师
            %p.f12.color6 这里写的是老师的简介信息，不能写太长
        .teacher-item
          %img.avatar{src: "/icon/avatar.png"}
          .item-desc
            %p.f14.color7.teacher-name 王小明老师
            %p.f12.color6 这里写的是老师的简介信息，不能写太长
        .teacher-item
          %img.avatar{src: "/icon/avatar.png"}
          .item-desc
            %p.f14.color7.teacher-name 王小明老师
            %p.f12.color6 这里写的是老师的简介信息，不能写太长
    .teacher-view-more
      %span.f12.color5 查看更多
      %img.more-icon{src: "/icon/more.png"}
%hr.div-line
.course-desc
  %span.f14.color7.fb 课程介绍
  .desc-box.f12.color7 开始介绍这门课程...
%hr.div-line
.recommend-div
  %span.recommend-title.f14.color7.fb 推荐课程
  .course-item
    .course-icon-div
      %img.course-icon{src: "/icon/example.png"}
    .word-div
      .course-row-div.clearfix
        %span.health-title.f12 健康养育
        %span.course-item-value.f14.color5 200
      .course-row-div.color7
        %span.course-name.f16 名字很长很长很长
        // %span.course-status.f8 线下
      .course-row-div.f12.color6
        %span.participate 2315人已学
        %span .
        %span 810条评论
  .course-item
    .course-icon-div
      %img.course-icon{src: "/icon/example.png"}
    .word-div
      .course-row-div.clearfix
        %span.psychology-title.f12 心理教育
        %span.course-item-value.f14.color5 200
      .course-row-div.color7.status-flex
        %span.name-span.f16 名字很长名字很长名字很名字
        %span.course-status.f8 线下
      .course-row-div.f12.color6
        %span.participate 2315人已报名
        %span .
        %span 5月9日开课
  .course-item
    .course-icon-div
      %img.course-icon{src: "/icon/example.png"}
    .word-div
      .course-row-div.clearfix
        %span.grow-title.f12 自我成长
        %span.course-item-value.f14.color5 200
      .course-row-div.color7
        %span.course-name.f16 名字很长很长很长
        // %span.course-status.f8 线下
      .course-row-div.f12.color6
        %span.participate 2315人已学
        %span .
        %span 810条评论
%hr.div-line
// 线下课程不显示评论
.course-content
  .review-title
    %span.title.f14.color7.fb 课程评论
    %span.f12.color7 (共810条)
    %p.review-score.f12.color5 4.8分/2100人已评
  .review-items-div
    .review-item
      %img.review-avatar{src: "/icon/avatar.png"}
      .item-desc
        %p.f12.color7.review-name 最赞评论者
        %p.f12.color5 3天前
        %p.f14.color7.review-content 这是评论 
        %span.f12.color5 评论来源：
        %span.f12.color5 第1课时
        .admire-div
          %span.f12.color5.admire-num 123
          %img.admire-icon{src: "/icon/like1_normal.png", 'data-ad'=> 'true'}
    .review-item
      %img.review-avatar{src: "/icon/avatar.png"}
      .item-desc
        %p.f12.color7.review-name 二赞评论者
        %p.f12.color5 3天前
        %p.f14.color7.review-content 这是评论 
        %span.f12.color5 评论来源：
        %span.f12.color5 第1课时
        .admire-div
          %span.f12.color5.admire-num 123
          %img.admire-icon{src: "/icon/like1_selected.png", 'data-ad'=> 'false'}
    .review-item
      %img.review-avatar{src: "/icon/avatar.png"}
      .item-desc
        %p.f12.color7.review-name 三赞评论者
        %p.f12.color5 3天前
        %p.f14.color7.review-content 这是评论 
        %span.f12.color5 评论来源：
        %span.f12.color5 第1课时
        .admire-div
          %span.f12.color5.admire-num 123
          %img.admire-icon{src: "/icon/like1_normal.png"}
%p.f12.color6.feed-review 最新评论
.feed-review-items-div
  .feed-review-item
    %img.review-avatar{src: "/icon/avatar.png"}
    .item-desc
      %p.f12.color7.review-name 评论者
      %p.f12.color5 3天前
      %p.f14.color7.review-content 这是评论 
      %span.f12.color5 评论来源：
      %span.f12.color5 第1课时
      .admire-div
        %span.f12.color5.admire-num 123
        %img.admire-icon{src: "/icon/like1_normal.png"}
  .feed-review-item
    %img.review-avatar{src: "/icon/avatar.png"}
    .item-desc
      %p.f12.color7.review-name 评论者
      %p.f12.color5 3天前
      %p.f14.color7.review-content 这是评论 
      %span.f12.color5 评论来源：
      %span.f12.color5 第1课时
      .admire-div
        %span.f12.color5.admire-num 123
        %img.admire-icon{src: "/icon/like1_normal.png"}
%img.upper{src: "/icon/top.png"}
.btn#add-btn{type: "button"} 立即报名
.btn#sign-btn{type: "button"} 课程签到
.btn#review-btn{type: "button"} 评价课程

@endsection
#reviewModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modal-body
        .course-review-div
          %p.name.f14.color7 "课程名字很长字很长字很长字很长字很长"这门课您认为可以打几星呢？
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
        .head-div
          %p.fb.tc.fb.color7.f18 个人资料
          %img.profile-close{src: "/icon/close.png"}
        .item-div 
          .item
            .left-div
              %img.avatar{src: "/icon/avatar.png"}
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
          .item-baby-div
            .left-div
              %img.avatar{src: "/icon/baby_female.png"}
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

          .add-baby-div
            %img.close-add-item{src: "/icon/close.png"}
            .left-div
              %img.avatar{src: "/icon/baby_female.png"}
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

@section('script')
<script src= "{{ mix('/js/course-show.js') }}"></script>
<script src= "/js/review-modal.js"></script>
@endsection