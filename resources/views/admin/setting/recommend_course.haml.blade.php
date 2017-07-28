@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_imgset_index.css') }}">
<link href="css/plugin/webuploader.css" rel="stylesheet" type="text/css">

:javascript
  window.token = "#{csrf_token()}"
  window.video = "#{route('videos.store')}"
  window.img_index = "#{route('settings.index').'?key=carousel'}"
  window.set_recommend = "#{route('settings.index')}"
    
@endsection

@section('content')
.content-area
  .main-top.direction
    %ul.set
      %li
        %a.f16{href: route('users.index')."?type=operator"} 人员管理
        .dot
      %li
        %a.f16.left-border{href: route('admin.profile')} 账号设置
      %li
        %a.f16.set-left-border#exit{href: "javascript:void(0)"} 退出登录
    
  .main-content.bg2
    %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{type: "button"} 编辑
    %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 保存
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li
            %a.f16.font-color1#announce 首页宣传
          %li.active
            %a.f16.font-color1#course 课程推荐
        .tab-content.bg3

          #tab2.tab-pane.active
            .desc-div
              .controls-div.font-color3.f14
                .controls.controls-row
                  %label.input-caption 新课速递推荐:
                  %span.unedit-box.longspan 课程的名字很长
                  %span.edit-box
                    %input.input-area.form-control{:type => "text"}
                .controls.controls-row
                  %label.input-caption 健康养育推荐:
                  %span.unedit-box.longspan 课程的名字很长
                  %span.edit-box
                    %input.input-area.form-control{:type => "text"}
                .controls.controls-row
                  %label.input-caption 心理教育推荐:
                  %span.unedit-box.longspan 课程的名字很长
                  %span.edit-box
                    %input.input-area.form-control{:type => "text"}
                .controls.controls-row
                  %label.input-caption 自我成长推荐:
                  %span.unedit-box.longspan 无
                  %span.edit-box
                    %input.input-area.form-control{:type => "text"}

@endsection

@section('script')
<script src="js/plugin/webuploader.js"></script>
<script src="js/recommend.js"></script>

@endsection