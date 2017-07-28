@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_imgset_index.css') }}">
<link href="css/plugin/webuploader.css" rel="stylesheet" type="text/css">

:javascript
  window.token = "#{csrf_token()}"
  window.img_store = "#{route('settings.store')}"
  window.img_index = "#{route('settings.index').'?key=carousel'}"
    
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
          %li.active
            %a.f16.font-color1#announce 首页宣传
          %li
            %a.f16.font-color1#course 课程推荐
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div
              // - if @users[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "icon/admin/undiscover.png"}
              // - else
              .img-div.unedit-box
                %img.img-item{src: "icon/banner.png"}
                %img.img-item{src: "icon/banner.png"}
                %img.img-item{src: "icon/banner.png"}

              .edit-img-div.edit-box.f14.font-color3
                #uploader.wu-example
                  .btns
                    #picker 添加图片
                    %button#ctlBtn.btn.btn-default 开始上传
                    %span.remind 请上传尺寸为750*320的图片文件
                .img-edit-div
                  .item
                    %img.edit-img-item{src: "icon/banner.png"}
                    %img.delete{src: "icon/admin/delete2.png"}
                    %span.path{style: "display:none;"}
                  .item
                    %img.edit-img-item{src: "icon/banner.png"}
                    %img.delete{src: "icon/admin/delete2.png"}
                    %span.path{style: "display:none;"}
                  #thelist.uploader-list

@endsection

@section('script')
<script src="js/plugin/webuploader.js"></script>

<script src="js/set_banner.js"></script>

@endsection