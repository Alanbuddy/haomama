@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_teacher_index.css') }}">

:javascript
    window.lesson_index = "#{route('lessons.index')}"
    window.lesson_store = "#{route('lessons.store')}"
    window.video = "#{route('videos.store')}"
    window.token = "#{csrf_token()}"
    window.teacher_new = "#{route('users.create')}"
    

@endsection
@section('search-input')
.user-search-box.f14.bg2
  %input.input-style#search-input.font-color3{:type => "text", :placeholder => "请输入讲师姓名、手机号", value: ""}
  .search#search-btn
@endsection
@section('content')
    
.main-content.bg2
  %button.btn.new-normal.font-color1.btn-position#new-client{type: "button", "data-target" => "#kidsaddModal", "data-toggle" => "modal"} 添加讲师
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li.active
          %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 所有讲师
      .tab-content.bg3
        #tab1.tab-pane.active
          .desc-div
            - if(count($items) == 0) 
              .undiscover.f14
                %img.undiscover-icon{src: "icon/admin/undiscover.png"}
            - else
              .table-box.f14
                %table.table.table-hover.table-height
                  %thead.th-bg.font-color2
                    %tr
                      %th 讲师姓名
                      %th 手机号
                      %th 职称
                  %tbody.font-color3
                    - foreach ($items as $item)
                      %tr
                        %td
                          %a{href: route('admin.user.show',$item->id).'?type=teacher'}=$item->name
                        %td=$item->phone
                        %td=json_decode($item->description)->title
            .select-page
              %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
              %span.choice-page
                != $items->links()

@endsection

@section('script')
<script src= "{{mix('/js/admin_teacher_index.js')}}"></script>

@endsection