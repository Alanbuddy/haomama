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
  window.comment = "#{route('admin.courses.comments',$course->id)}"
  window.review = "#{route('comments.update', -1)}"

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
            - if(count($items) == 0)
              .undiscover
                %img.undiscover-icon{src: "icon/admin/undiscover.png"}
            - else
              .user-review-box
                .user-search-box.f14.bg2
                  %input.input-style#search-input.font-color3{:type => "text", :placeholder => "输入关键词", value: ""}
                  .search#search-btn
                - foreach($items as $item)
                  .review-items
                    .img-div
                      %img.avatar-icon{src: $item->user->avatar ? $item->user->avatar : "icon/admin/avatar-icon.png"}
                    .review-div
                      .head-div.clearfix
                        %p.user-name.fl.font-color2= $item->user->name
                        %span.review-id{style: "display: none;"}= $item->id
                        %span.validity{style: "display:none;"}= $item->validity
                        - if(!$item->validity)
                          .btn.fr.finish-normal.font-color1.show-review.review-operation{type: "button"} 显示评论
                        - else
                          .btn.fr.edit-normal.font-color1.hide-review.review-operation{type: "button"} 隐藏评论
                      %p.reviews.font-color3.f14= $item->content
                      .time-div.font-color4
                        %span.review-date= $item->created_at
              .select-page.mt20
                %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                %span.choice-page
                  != $items->links()
@endsection

@section('script')
<script src= "{{mix('/js/admin_course_show.js')}}"></script>
<script src="js/admin-comment.js"></script>

@endsection