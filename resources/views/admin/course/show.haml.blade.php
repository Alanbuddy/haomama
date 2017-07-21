@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_course_show.css') }}">
<link href="css/plugin/jquery.tag-editor.css" rel="stylesheet" type="text/css">

:javascript
  window.course_index = "#{route('courses.index')}"
  window.course_publish = "#{route('courses.publish',$course->id)}"
  window.token = "#{csrf_token()}"
@endsection

@section('content')
.content-area
  .main-top.direction
    %a{href: route('courses.index')}
      %img.back{src: "icon/admin/back.png"}
    %ul.set
      %li
        %a.f16{href: route('users.index')} 人员管理
        .dot
      %li
        %a.f16.left-border{href: route('admin.profile')} 账号设置
      %li
        %a.f16.set-left-border#exit{href: "#"} 退出登录

  .main-content.bg2
    // %button.btn.delete-normal.font-color1.unshelve-btn-position#unshelve-btn.operation.available{type: "button"} 下架课程
    %button.btn.delete-normal.font-color1.unshelve-btn-position#shelve-btn.operation.unavailable{type: "button"} 上线课程
    %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{type: "button"} 编辑
    %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 保存
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1#course-desc{"data-toggle" => "tab", :href => "#tab1"} 课程详情
          %li
            %a.f16.font-color1#register-message{"data-toggle" => "tab", :href => "#tab2"} 报名信息
          %li
            %a.f16.font-color1#course-comment{"data-toggle" => "tab", :href => "#tab3"} 课程评论
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div.font-color3.clearfix.f14
              .text-message.unedit
                .controls.controls-row
                  %label.input-caption 课程名称:
                  %span.unedit-box 课程的名字很长
                  %span.font-color-red.unedit-box (新课速递推荐)
                  %span.edit-box
                    %input.input-area.form-control#course-name{:type => "text", placeholder: "必填"}
                .controls.controls-row
                  %label.input-caption 课程类型:
                  %span.unedit-box.short-span.mr40 自我成长
                  %span.edit-box
                    %select.form-control.input-width#course-type
                      %option 请选择类型
                      %option{value: "类型一"} 类型一
                      %option{value: "类型二"} 类型二
                      %option{value: "类型三"} 类型三
                  %label.input-caption 课程节数:
                  %span.unedit-box.short-span 8
                  %span.edit-box
                    %input.form-control.input-width{:type => "text"}
                .controls.controls-row
                  %label.input-caption 课程价格:
                  %span.unedit-box.short-span.mr40 80
                  %span.edit-box
                    %input.form-control.input-width#course-price{:type => "text"}
                  %label.input-caption 促销价格:
                  %span.unedit-box.short-span.font-color-red 50/无促销价格时显示无
                  %span.edit-box
                    %input.form-control.input-width{:type => "text"}
              %input#previewImg{:onchange => "previewImage(this)", :type => "file", style: "display:none;"}
              .photo#preview
                %img.unedit-box{src: "icon/admin/photo-course.png"}
                %img.edit-box.edit-photo#imghead{src: "icon/admin/photo-course.png", onclick: "$('#previewImg').click()"}
                
            .controls-div.font-color3.f14
              .controls.controls-row.tag-flex
                %label.input-caption 课程标签: 
                %span.unedit-box.ml4
                  %span 育儿 
                  %span 育儿 
                  %span 育儿 
                  %span 育儿 
                  %span 育儿 
                %span.edit-box.tag-div
                  #type-tag
              .controls.controls-row.no-mb.tag-flex
                %label.input-caption 授课老师:
                %span.unedit-box.ml4
                  %span 育儿 
                  %span 育儿 
                  %span 育儿 
                  %span 育儿 
                  %span 育儿
                %span.edit-box.teacher-div
                  #teacher-tag 

              .course-introduce.introduce-flex
                %span.introduce 课程介绍:
                %span.unedit-box.ml4 该课程是少儿类视频第一名
                %span.edit-box.wangedit-area
                  #edit-area 
              .lesson-div
                %span.unedit-box.introduce 课程课时:
                %span.edit-box 选择课时:
                %span.unedit-box.ml4.lesson-position
                  .caption-item
                    %img{src: "icon/admin/music-small.png"}
                    %span 第一课时标题
                  .caption-item
                    %img{src: "icon/admin/video-small.png"}
                    %span 第一课时标题
                %span.edit-box.addlesson 添加
                .lesson-title
                  %ol.example

              .course-lesson.introduce-flex
                %span.introduce 课时标题:
                .unedit-box.ml4
                  %p 第一课时标题
                  %p 第一课时标题
                  %p 第一课时标题
                  %p 第一课时标题
                  %p 第一课时标题
                  %p 第一课时标题
                %span.edit-box.wangedit-area
                  #title-area 
          #tab2.tab-pane
            .desc-div
              // - if @courses[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
              // - else
              .table-box
                %table.table.table-hover.table-height.f14
                  %thead.th-bg.font-color2
                    %tr
                      %th 微信ID
                      %th 微信名
                      %th 手机号
                      %th 购买时间
                      %th 价格
                      %th 报名状态
                      
                  %tbody.font-color3
                    %tr
                      %td dsagfagafg012
                      %td 线上视频
                      %td 132446235654
                      %td 2017/06/12 22:12:08
                      %td 80
                      // %td 未付款
                      %td.font-color-brown 已付款
              .tag2-foot.clearfix
                %span.num-div.font-color3.f16
                  %span 总购买人数:
                  %span.mr30 123
                  %span 总付款人数:
                  %span 70

                %span.select-page.tag2-page
                  %span.totalitems 共2页，总计18条
                  %span.choice-page
                    %ul.pagination.pagination-sm
                      %li
                        %a{href: "#"} «
                      %li
                        %a{href: "#"} 1
                      %li
                        %a{href: "#"} »
          #tab3.tab-pane
            .desc-div
              // - if @reviews[:data].blank?
              //   .undiscover
              //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
              // - else
              .user-review-box
                .user-search-box.f14.bg2
                  %input.input-style#search-input.font-color3{:type => "text", :placeholder => "输入关键词", value: ""}
                  .search#search-btn
                .review-items
                  .img-div
                    %img.avatar-icon{src: "icon/admin/avatar-icon.png"}
                  .review-div
                    .head-div.clearfix
                      %p.user-name.fl.font-color2 夏天的雪
                      
                      .btn.fr.finish-normal.font-color1.show-review{type: "button"} 显示评论
                      
                      // .btn.fr.edit-normal.font-color1.hide-review{type: "button"} 隐藏评论
                    %p.reviews.font-color3.f14 我很喜欢这门课，老师讲的很nice
                    .time-div.font-color4
                      %span.review-date 2017/05/23 13:30
              .select-page.mt20
                %span.totalitems 共2页，总计18条
                %span.choice-page
                  %ul.pagination.pagination-sm
                    %li
                      %a{href: "#"} «
                    %li
                      %a{href: "#"} 1
                    %li
                      %a{href: "#"} »
@endsection
#lessonModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1", style: "z-index: 10006"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/admin/delete1.png"}
      .modal-body.f14
        .all-div
          .checkbox
            %label
              %input{type: "checkbox", id: "all-no"} 全选/全不选
        .checkbox
          %label
            %input{type: "checkbox", name: "lesson-check", value: "第一课时"} 第一课时
        .checkbox
          %label
            %input{type: "checkbox", name: "lesson-check", value: "第二课时"} 第二课时
        .checkbox
          %label
            %input{type: "checkbox", name: "lesson-check", value: "第三课时"} 第三课时
        .checkbox
          %label
            %input{type: "checkbox", name: "lesson-check"} 第一课时
        .checkbox
          %label
            %input{type: "checkbox", name: "lesson-check"} 第一课时
        .checkbox
          %label
            %input{type: "checkbox", name: "lesson-check"} 第一课时
        .checkbox
          %label
            %input{type: "checkbox", name: "lesson-check"} 第一课时
        .checkbox
          %label
            %input{type: "checkbox", name: "lesson-check"} 第一课时
        .checkbox
          %label
            %input{type: "checkbox", name: "lesson-check"} 第一课时
        .checkbox
          %label
            %input{type: "checkbox", name: "lesson-check"} 第一课时
        
        .btn.font-color1.confirm-btn-position#confirm-btn{type: "button"} 确定
        .select-page 
          %span.totalitems 共2页，总计18条
          %span.choice-page
            %ul.pagination.pagination-sm
              %li
                %a{href: "#"} «
              %li
                %a{href: "#"} 1
              %li
                %a{href: "#"} »


#shelfModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "/icon/admin/close.png"}
      .modal-body
        %p.message 是否确认下架当前课程？
        .btn-div
          %button.btn#shelf-cancel{type: "button"} 取&nbsp消
          %button.btn#shelf-confirm{type: "button"} 确&nbsp定

@section('script')
<script src= "{{mix('/js/admin_course_show.js')}}"></script>
<script src="js/plugin/jquery-ui.min.js"></script>
<script src="js/plugin/wangEditor.min.js"></script>
<script src="js/plugin/jquery.tag-editor.min.js"></script>
<script src="js/preview.js"></script>
<script src="js/lesson-title.js"></script>
<script src="js/admin_course_online_show.js"></script>

@endsection