@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_imgset_index.css') }}">
<link href="css/plugin/webuploader.css" rel="stylesheet" type="text/css">
<link href="css/plugin/jquery-ui.css" rel="stylesheet" type="text/css">

:javascript
  window.token = "#{csrf_token()}"
  window.video = "#{route('videos.store')}"
  window.img_index = "#{route('settings.index').'?key=carousel'}"
  window.set_recommend = "#{route('settings.index')}"
  window.course_search = "#{route('courses.search')}"
    
@endsection
@section('search-input')
%a.hide{href: route('lessons.index')}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')
    
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
              - foreach($arr as $k=>$v)
                .controls.controls-row
                  %label.input-caption= $k.'推荐:'
                  %span.unedit-box.longspan#new-span= $v ? $v->name : "无"
                  %span.edit-box
                    %input.input-area.form-control#new{:type => "text"}
                  %span.new-id{style: "display:none;"}

@endsection

@section('script')
<script src="js/plugin/jquery-ui.min.js"></script>
<script src="js/plugin/webuploader.js"></script>
<script src="js/recommend.js"></script>

@endsection