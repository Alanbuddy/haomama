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
        %li
          %a.f16.font-color1 关注用户
        %li.active
          %a.f16.font-color1 未关注用户
      .tab-content.bg3

        #tab2.tab-pane.active
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
                      %th 宝宝姓名
                      %th 宝宝性别
                      %th 宝宝年龄
                      %th 关注状态
                  %tbody.font-color3
                    // - @users[:data].each do |u|
                    %tr
                      %td.client-show adfgafgafd132
                      %td 风中凌乱
                      %td 12324543546 
                      %td 妈妈 
                      %td 凉粉 
                      %td 女 
                      %td 3岁  
                      %td 取消关注/或者未曾关注  
                      // %td 未曾关注  
              .select-page 
                .select-page 
                  %span.totalitems= "共{$items->lastPage()}页，总计{$items->total()}条"
                  %span.choice-page
                    != $items->links()

@endsection

@section('script')
<script src= "{{mix('/js/admin_client_index.js')}}"></script>

@endsection