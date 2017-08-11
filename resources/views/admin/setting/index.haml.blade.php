@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_imgset_index.css') }}">
<link href="css/plugin/webuploader.css" rel="stylesheet" type="text/css">

:javascript
  window.token = "#{csrf_token()}"
  window.img_store = "#{route('settings.store')}"
  window.img_index = "#{route('settings.index').'?key=carousel'}"
  window.set_recommend = "#{route('settings.index')}"
    
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
        %li.active
          %a.f16.font-color1#announce 首页宣传
        %li
          %a.f16.font-color1#course 课程推荐
      .tab-content.bg3
        #tab1.tab-pane.active
          .desc-div
            .img-div.unedit-box
              - if(count($images) == 0)
                .undiscover.f14
                  %img.undiscover-icon{src: "icon/admin/undiscover.png"}
              - else
                - foreach($images as $item)
                  %img.img-item{src: strpos($item, '/') == 0 ? substr($item,1) : $item}

            .edit-img-div.edit-box.f14.font-color3
              #uploader.wu-example
                .btns
                  #picker 添加图片
                  %button#ctlBtn.btn.btn-default 开始上传
                  %span.remind 请上传尺寸为750*320的图片文件
              .img-edit-div
                - foreach($images as $item)
                  .item
                    %img.edit-img-item.old_img{src: strpos($item, '/') == 0 ? substr($item,1) : $item}
                    %img.delete{src: "icon/admin/delete2.png"}
                    %span.path{style: "display:none;"}
                #thelist.uploader-list

@endsection

@section('script')
<script src="js/plugin/webuploader.js"></script>
<script src="js/set_banner.js"></script>

@endsection