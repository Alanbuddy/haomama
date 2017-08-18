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
                    -foreach($items as $item)
                      %tr
                        %td=$item->time
                        %td=$item->page
                        %td=$item->duration
                    
              .select-page 
                %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                %span.choice-page
                  != $items->links()
@endsection

@section('script')
<script src= "js/admin_client_desc.js"></script>

@endsection