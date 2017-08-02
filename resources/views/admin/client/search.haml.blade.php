@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_client_index.css') }}">

:javascript
    window.lesson_index = "#{route('lessons.index')}"
    window.lesson_store = "#{route('lessons.store')}"
    window.video = "#{route('videos.store')}"
    window.token = "#{csrf_token()}"
  

@endsection
@section('search-input')
.user-search-box.f14.bg2
  %input.input-style#search-input.font-color3{:type => "text", :placeholder => "请输入用户微信ID、微信名、手机号、宝宝姓名", value: ""}
  .search#search-btn
@endsection
@section('content')
    
.main-content.bg2
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li.active
          %a.f16.font-color1 用户搜索
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
                      %th 微信ID
                      %th 微信名
                      %th 手机号码
                      %th 家长身份
                      %th 关注状态
                      %th 宝宝姓名
                      %th 宝宝性别
                      %th 宝宝年龄
                  %tbody.font-color3
                    - foreach($items as $item)
                      %tr
                        %td.client-show{rowspan: count($item->baby)}= $item->openid
                        %td{rowspan: count($item->baby)}= $item->wx ? json_decode($item->wx)->nickname : "无"  
                        %td{rowspan: count($item->baby)}= $item->phone
                        %td{rowspan: count($item->baby)}= $item->parenthood
                        %td{rowspan: count($item->baby)} 关注状态
                        - if(count($item->baby) == 0)
                          %td= "无"
                          %td= "无"
                          %td= "无"
                        - else
                          - for($i=0;$i<count($item->baby);$i++)
                            %td= json_decode($item->baby)[$i]->name
                            %td= json_decode($item->baby)[$i]->gender
                            %td.age= json_decode($item->baby)[$i]->birthday
              .select-page 
                %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                %span.choice-page
                  != $items->links()
@endsection

@section('script')
<script src= "{{mix('/js/admin_client_index.js')}}"></script>


@endsection