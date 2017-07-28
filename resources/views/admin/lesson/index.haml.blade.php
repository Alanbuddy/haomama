@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_lesson_index.css') }}">
:javascript
    window.lesson_index = "#{route('lessons.index')}"
    window.lesson_create = "#{route('lessons.create')}"
    window.token = "#{csrf_token()}"
@endsection

@section('content')
.content-area
  .main-top.direction
    .user-search-box.f14.bg2
      %input.input-style#search-input.font-color3{:type => "text", :placeholder => "输入课时标题", value: ""}
      .search#search-btn
    %ul.set
      %li
        %a.f16{href: route('users.index')."?type=operator"} 人员管理
        .dot
      %li
        %a.f16.left-border{href: route('admin.profile')} 账号设置
      %li
        %a.f16.set-left-border#exit{href: "javascript:void(0)"} 退出登录
    
  .main-content.bg2
    %button.btn.new-normal.font-color1.btn-position#new-template{type: "button"} 上传课时
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1#video 视频课时
          %li
            %a.f16.font-color1#audio 音频课时

        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div
              .table-box
                %table.table.table-hover.table-height.f14
                  %thead.th-bg.font-color2
                    %tr
                      %th 课时标题
                      %th 上传时间
                      %th 上线时间
                  %tbody.font-color3
                    -foreach ($items as $lesson) 
                      %tr{class: ""}
                        %td.show-name
                          %a{href:route('admin.lesson.show',$lesson->id)}=$lesson->name
                        %td =$lesson->created_at
                        %td =$lesson->updated_at
                      
              .select-page 
                %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                %span.choice-page
                  != $items->links() 

#add_lessonModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/admin/delete1.png"}
      .modal-body
        .courses-div
          .item.lesson-video
            %img{src: "icon/admin/video.png"}
            %p 视频课时
          .item.lesson-audio
            %img{src: "icon/admin/music.png"}
            %p 音频课时                          
@endsection

@section('script')
<script src= "{{mix('/js/admin_lesson_index.js')}}"></script>
<script src= "js/admin-add-lesson.js"></script>


@endsection