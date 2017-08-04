@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_course_show.css') }}">
<link href="css/plugin/jquery.tag-editor.css" rel="stylesheet" type="text/css">
<link href="css/plugin/jquery-ui.css" rel="stylesheet" type="text/css">

:javascript
  window.course_index = "#{route('courses.index')}"
  window.course_publish = "#{route('courses.publish',$course->id)}"
  window.course_show = "#{route('admin.courses.show',$course->id)}"
  window.token = "#{csrf_token()}"
  window.add_teacher = "#{route('users.search')}"
  window.course_update = "#{route('courses.update', $course->id)}"
  window.tag_store = "#{route('terms.store')}"
  window.tag_destroy = "#{route('terms.destroy',-1)}"
  window.lessons_index = "#{route('lessons.index')}"
  window.student = "#{route('admin.courses.students')}"
  window.comment = "#{route('admin.courses.comments')}"

@endsection
@section('search-input')
%a{href: route('courses.index')}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')

.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li
          %a.f16.font-color1#course-desc 课程详情
        %li
          %a.f16.font-color1#register-message 报名信息
        %li.active
          %a.f16.font-color1#course-comment 课程评论
      .tab-content.bg3
        #tab3.tab-pane.active
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

#lessonModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1", style: "z-index: 10006"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/admin/delete1.png"}
      .modal-body.f14
        .all-div
          .checkbox
            %label
              %input{type: "checkbox", id: "all-no"} 全选/全不选
        .checkbox-items
        
        .btn.font-color1.confirm-btn-position#confirm-btn{type: "button"} 确定
        .select-page
          %span.totalitems
          .quotes#Pagination


#shelfModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/admin/close.png"}
      .modal-body
        - if($course->status == "draft")
          %p.message 是否确认上线当前课程？
        - else
          %p.message 是否确认下架当前课程？
        .btn-div
          %button.btn#shelf-cancel{type: "button"} 取&nbsp消
          %button.btn#shelf-confirm{type: "button"} 确&nbsp定
@endsection


@section('script')
<script src= "{{mix('/js/admin_course_show.js')}}"></script>
<script src="js/plugin/jquery-ui.min.js"></script>
<script src="js/plugin/wangEditor.min.js"></script>
<script src="js/plugin/jquery.tag-editor.min.js"></script>
<script src="js/plugin/jquery-sortable.js"></script>
<script src="js/preview.js"></script>
<script src="js/admin_course_online_show.js"></script>

@endsection