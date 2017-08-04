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
        %li.active
          %a.f16.font-color1#register-message 报名信息
        %li
          %a.f16.font-color1#course-comment 课程评论
      .tab-content.bg3
        #tab2.tab-pane.active
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