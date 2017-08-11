@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_lesson_index.css') }}">
:javascript
    window.lesson_index = "#{route('lessons.index')}"
    window.lesson_create = "#{route('lessons.create')}"
    window.token = "#{csrf_token()}"
    window.lesson_search = "#{route('admin.lessons.search')}"

@endsection
@section('search-input')
.user-search-box.f14.bg2
  %input.input-style#search-input.font-color3{:type => "text", :placeholder => "输入课时标题", value: ""}
  .search#search-btn
@endsection
@section('content')
    
.main-content.bg2
  %button.btn.new-normal.font-color1.btn-position#new-template{type: "button"} 上传课时
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li.active
          %a.f16.font-color1 搜索结果

      .tab-content.bg3
        #tab1.tab-pane.active
          .desc-div
            - if(count($items) == 0) 
              .undiscover.f14
                %img.undiscover-icon{src: "icon/admin/undiscover.png"}
            - else
              .table-box
                %table.table.table-hover.table-height.f14
                  %thead.th-bg.font-color2
                    %tr
                      %th 课时标题
                      %th 上传时间
                      %th 上线时间
                      %th 课时类型
                  %tbody.font-color3
                    -foreach ($items as $lesson) 
                      %tr{class: ""}
                        %td.show-name
                          %a{href:route('admin.lesson.show',$lesson->id)}=$lesson->name
                        %td =$lesson->created_at
                        %td =$lesson->updated_at
                        %td =$lesson->type == "video" ? "视频" : "音频" 
                      
              .select-page 
                %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                %span.choice-page
                  != $items->links() 
                      
@endsection

@section('script')
<script src= "{{mix('/js/admin_lesson_index.js')}}"></script>
<script src= "js/admin-add-lesson.js"></script>


@endsection