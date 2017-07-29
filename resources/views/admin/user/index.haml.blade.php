@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/user-index.css') }}">
:javascript
    // window.course_index = "#{route('courses.index')}"
    // window.course_create = "#{route('courses.create')}"
    // window.logout = "#{route('logout')}"
    // window.login = "#{route('login')}"
    // window.token = "#{csrf_token()}"
@endsection

@section('search-input')
%a.hide{href: route('lessons.index')}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')

.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li.active
          %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 人员管理
      .tab-content.bg3
        #tab1.tab-pane.active
          .desc-div
            - if(count($items) == 0)
              .undiscover.f14
                %img.undiscover-icon{src: "icon/admin/undiscover.png"}
            - else
              .table-box.f14
                %table.table.table-hover.table-height#admin
                  %thead.th-bg.font-color2
                    %tr
                      %th 手机号
                      %th 姓&nbsp&nbsp名
                      %th 状&nbsp&nbsp态
                      %th{colspan: "2"} 操&nbsp&nbsp作
                  %tbody.font-color3
                    - foreach($items as $item)
                      %tr
                        %td= $item->phone
                        %td= $item->name
                        %td 新注册账号/正常/关闭
                        %td
                          // %a.change_status.available.font-color-brown{:href => "javascript:void(0);"} 关闭
                          %a.change_status.unavailable.font-color-green{:href => "javascript:void(0);"} 开通
                        %td
                          %a.font-color-red{href: "javascript:void(0)"} 删除
                .select-page 
                  %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                  %span.choice-page
                    != $items->links()
@endsection

@section('script')
<script src= "js/admin-user-index.js"></script>


@endsection