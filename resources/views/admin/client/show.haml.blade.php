@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_client_show.css') }}">
:javascript
  window.client_desc="#{route('admin.user.log',$user->id)}"
  window.client_purchase="#{route('admin.user.order',$user->id)}"

@endsection
@section('search-input')
%a{href: route('users.index')."?type=user"}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')

.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li.active
          %a.f16.font-color1#desc 访问详情
        %li
          %a.f16.font-color1#pay 课程购买
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
                      %th 访问时间
                      %th 访问页面
                      %th 停留时间
                  %tbody.font-color3
                    // - @users[:data].each do |u|
                    %tr
                      %td 2017/06/26 22:12:06
                      %td 课程名称(第二课时)
                      %td 5 s/或者25 min
                    %tr
                      %td 2017/06/26 22:12:06
                      %td 课程名称(支付完成)
                      %td 5 s/25 min
                    %tr
                      %td 2017/06/26 22:12:06
                      %td 课程名称
                      %td 5 s/25 min
                    %tr
                      %td 2017/06/26 22:12:06
                      %td 搜索结果页(关键词：手工)
                      %td 5 s/25 min
                    %tr
                      %td 2017/06/26 22:12:06
                      %td 首页
                      %td 5 s/25 min
              .select-page 
                %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                %span.choice-page
                  != $items->links()
@endsection

@section('script')
<script src= "{{mix('/js/admin_client_show.js')}}"></script>

@endsection