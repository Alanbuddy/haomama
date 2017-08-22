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
  window.student = "#{route('admin.courses.students',$course->id)}"
  window.comment = "#{route('admin.courses.comments', $course->id)}"
  window.course_del = "#{route('courses.destroy',$course->id)}"

@endsection
@section('search-input')
%a{href: route('courses.index')}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')

.main-content.bg2
  
  - if($course->status == "draft")
    %button.btn.delete-normal.font-color1.unshelve-btn-position#unshelve-btn.operation{type: "button"} 上线课程
    %button.btn.delete-normal.font-color1.delete-btn-position#delete-btn{type: "button"} 删除
  - if(auth()->user()->hasRole('admin') && $course->status != "draft")
    %button.btn.delete-normal.font-color1.unshelve-btn-position#shelve-btn.operation{type: "button"} 下架课程
  %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{type: "button"} 编辑
  %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 保存
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li.active
          %a.f16.font-color1#course-desc 课程详情
        %li
          %a.f16.font-color1#register-message 报名信息
        %li
          %a.f16.font-color1#course-comment 课程评论
      .tab-content.bg3
        #tab1.tab-pane.active
          .desc-div.font-color3.clearfix.f14
            .text-message.unedit
              .controls.controls-row
                %label.input-caption 课程名称:
                %span.unedit-box#name-span= $course->name
                %span.font-color-red.unedit-box= ($course->recommendation)
                %span.edit-box
                  %input.input-area.form-control#course-name{:type => "text", placeholder: "必填"}
              .controls.controls-row
                %label.input-caption 课程类型:
                %span.unedit-box.short-span.mr40#type-span{"data-type-id"=> $course->category->id}=$course->category->name
                %span.edit-box
                  %select.form-control.input-width#course-type
                    %option 请选择类型
                    - foreach ($categories as $category )
                      %option{value: $category->id}= $category->name
                %label.input-caption 课程节数:
                %span.unedit-box.short-span#length-span= count(json_decode($course->titles))
                %span.edit-box
                  %input.form-control.input-width#course-length{:type => "text"}
              .controls.controls-row
                %label.input-caption 课程价格:
                %span.unedit-box.short-span.mr40#original-span= $course->original_price
                %span.edit-box
                  %input.form-control.input-width#course-price{:type => "text"}
                %label.input-caption 促销价格:
                %span.unedit-box.short-span.font-color-red#price-span= $course->price ? $course->price : "无"
                %span.edit-box
                  %input.form-control.input-width#pay-price{:type => "text"}
            %input#previewImg{:onchange => "previewImage(this)", :type => "file", style: "display:none;"}
            .photo#preview
              %img.unedit-box.unedit-photo{src: $course->cover ? $course->cover : "icon/admin/photo-course.png"}
              %img.edit-box.edit-photo#imghead{src: $course->cover ? $course->cover : "icon/admin/photo-course.png", onclick: "$('#previewImg').click()"}
            .cover-path{style: "display:none;"}= $course->cover ? $course->cover : "icon/admin/photo-course.png"
              
          .controls-div.font-color3.f14
            .controls.controls-row.tag-flex#edit-tag
              %label.input-caption 课程标签: 
              %span.unedit-box.ml4
                - foreach($course->tags as $tag)
                  %span.tag-span{"data-id" => $tag->id}= $tag->name
              
              %span.edit-box.tag-div
                #type-tag
            .hot-tag-div.edit-box
              - foreach($popularTags as $tag)
                %span{value: $tag->id}= $tag->name
            .create-tag-div{style: "display:none"}
            .controls.controls-row.no-mb.tag-flex
              %label.input-caption.teacher-tag 授课老师:
              %span.unedit-box.ml4
                -foreach($course->teachers as $teacher)
                  %span.teacher-tag-span=$teacher->name
              %span.edit-box
                - foreach($course->teachers as $teacher)
                  %span.add-tag
                    %span.teacher-name= $teacher->name
                    %span.teacher-id= $teacher->id
                    %img.delete-tag{src: "icon/admin/delete.png"}
            
            .edit-box.teacher-div
              %input#teacher{type: "text"}

            .course-introduce.introduce-flex
              %span.introduce 课程介绍:
              %span.unedit-box.ml4#desc-span!= $course->description
              %span#desc-html{style: "display:none;"}= $course->description
              %span.edit-box.wangedit-area
                #edit-area 
            .lesson-div
              %span.unedit-box.introduce 课程课时:
              %span.edit-box 选择课时:
              %span.unedit-box.lesson-position
                - foreach($lessons as $lesson)
                  - if($lesson->type=='audio')
                    .caption-item
                      %img{src: "icon/admin/music-small.png"}
                      %span= $lesson->name
                  - if($lesson->type =='video')
                    .caption-item
                      %img{src: "icon/admin/video-small.png"}
                      %span= $lesson->name
              %span.edit-box.addlesson 添加
              .lesson-title
                %ol.example
                  - foreach($lessons as $lesson)
                    - if($lesson->type == 'audio')
                      %li{"data-id" => $lesson->id}
                        %span.sort-span
                          =$lesson->name
                          %img.sort-delete{src: "icon/admin/delete.png"}
                    - if($lesson->type == "video")
                      %li{"data-id" => $lesson->id}
                        %span.sort-span
                          =$lesson->name
                          %img.sort-delete{src: "icon/admin/delete.png"}

            .course-lesson.introduce-flex
              %span.introduce 课时标题:
              .unedit-box.ml4#unedit-title
                - if ($course->titles)
                  - foreach(json_decode($course->titles) as $title)
                    %p.title-desc= $title

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
<script src="js/admin_course_online_show.js?v=2"></script>

@endsection