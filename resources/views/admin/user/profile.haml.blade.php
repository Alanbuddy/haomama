@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/user-profile.css') }}">
:javascript
  window.account_set = "#{route('admin.profile')}"
  window.token = "#{csrf_token()}"
@endsection

@section('search-input')
%a.hide{href: route('lessons.index')}
  %img.back{src: "icon/admin/back.png"}
@endsection
@section('content')

.main-content.bg2
  %button.btn.finish-normal.font-color1.btn-position#finish{type: "button"} 完成
  .table-div
    .tabbable
      %ul.nav.nav-tabs
        %li.active
          %a.f16#account-set{"data-toggle" => "tab", :href => "#tab1"} 账号设置
      .tab-content.bg3
        #tab1.tab-pane.active
          .desc
            %p.f24.font-color4.tc.bg2.work-cert 工作证
            .person-div
              %input#previewImg{:onchange => "previewImage(this)", :type => "file", style: "display:none;"}
              .photo-div#preview
                %img.bg2.photo#imghead{src: $user->avatar ?  $user->avatar : "icon/admin/default.png", onclick: "$('#previewImg').click()"}
                %img.figure{src: "icon/admin/photo.png"}
              %p.mobile
                %span.f20.font-color3.mobile-num 手机号:
                %span.f20.font-color3= $user->phone
              %p
                %span.f20.font-color3.name 姓名:
                %input.form-control.font-color3#user_name{placeholder: "请输入姓名", value: auth()->user()->name ? auth()->user()->name : ""}

#setModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modalheader
        %img.close{"aria-hidden" => "true", "data-dismiss" => "modal", src: "icon/admin/close.png"}
      .modal-body
        %p.message 您尚未保存账号设置，是否确定离开？
        .btn-div
          %button.btn#set-cancel{type: "button"} 取&nbsp消
          %button.btn#set-confirm{type: "button"} 确&nbsp定
@endsection

@section('script')
<script src="js/profile-preview.js"></script>
<script src= "js/admin-user-profile.js"></script>


@endsection