@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/user-index.css') }}">
:javascript
    window.token = "#{csrf_token()}"
    window.enable = "#{route('admin.user.enable',-1)}"
    window.disable = "#{route('admin.user.disable',-1)}"
    window.delete = "#{route('users.destroy',-1)}"

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
                        %td.status= empty($item->status) ? "新注册账号" : $item->status 
                        %td.open-close{"data-id" => $item->id}
                          - if($item->status == "enabled")
                            %span.change_status.available.operation 关闭
                          - else
                            %span.change_status.unavailable.operation 开通
                        %td
                          %span.delete-tr.font-color-red 删除
                .select-page 
                  %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                  %span.choice-page
                    != $items->links()
@endsection

@section('script')
<script src= "js/admin-user-index.js"></script>


@endsection