@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin_imgset_index.css') }}">
<link href="/css/plugin/webuploader.css" rel="stylesheet" type="text/css">

:javascript
  window.token = "#{csrf_token()}"
  window.video = "#{route('videos.store')}"
    
@endsection

@section('content')
.content-area
  .main-top.direction
    %ul.set
      %li
        %a.f16{href: route('users.index')} 人员管理
        .dot
      %li
        %a.f16.left-border{href: route('admin.profile')} 账号设置
      %li
        %a.f16.set-left-border#exit{href: "#"} 退出登录
    
  .main-content.bg2
    %button.btn.edit-normal.font-color1.create-btn-position#edit-btn{type: "button"} 编辑
    %button.btn.edit-normal.font-color1.create-btn-position#tab2-edit-btn{type: "button"} 编辑

    %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 保存
    %button.btn.finish-normal.font-color1.finish-btn-position#tab2-finish-btn{type: "button"} 保存
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1#announce{"data-toggle" => "tab", :href => "#tab1"} 首页宣传
          %li
            %a.f16.font-color1#course{"data-toggle" => "tab", :href => "#tab2"} 课程推荐
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div
              // - if @users[:data].length == 0
              //   .undiscover.f14
              //     %img.undiscover-icon{src: "/icon/admin/undiscover.png"}
              // - else
              .img-div.unedit-box
                %img.img-item{src: "/icon/banner.png"}
                %img.img-item{src: "/icon/banner.png"}
                %img.img-item{src: "/icon/banner.png"}
              .edit-img-div.edit-box.f14.font-color3
                #uploader.wu-example
                  #thelist.uploader-list
                  .btns
                    #picker 添加图片
                    %span 请上传尺寸为750*320的图片文件
                    
                .img-edit-div.mt40
                  .item
                    %img.edit-img-item{src: "/icon/banner.png"}
                    %img.delete{src: "/icon/admin/delete2.png"}
                  .item
                    %img.edit-img-item{src: "/icon/banner.png"}
                    %img.delete{src: "/icon/admin/delete2.png"}

          #tab2.tab-pane
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
<script src= "{{mix('/js/admin_imgset_index.js')}}"></script>
<script src="/js/plugin/webuploader.js"></script>

<script src="/js/fileupload.js"></script>

@endsection