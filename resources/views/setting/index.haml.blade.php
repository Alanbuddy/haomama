@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/setting-index.css') }}">

@endsection
@section('content')
.head-div
  %p.fb.tc.fb.color7.f18 个人资料
  %img.back{src: "/icon/back.png"}
.item-div 
  .item.parent-div
    .left-div
      %img.avatar{src: "/icon/avatar.png"}
    .right-div
      .row-div
        %label.f14.color7.fn 微信名称
        %p.f12.color6.fn#wechat-name 限制十四个字
      .row-div
        %label.f14.color7.fn 家长身份
        %span.f12.color6.span-desc 妈妈
        %select.input-div#parent
          %option{value: "请选择"} 请选择
          %option{value: "爸爸"} 爸爸
          %option{value: "妈妈"} 妈妈
      .row-div
        %label.f14.color7.fn 手机号码
        %p.f12.color6#mobile-span 13011111111
        // %p.replace.f12.color10{"data-toggle" => "modal", "data-target" => "#mobileModal"} 更换
        %p.replace.f12.color10 更换
      .row-div
        %a.edit.f12.color10#parent-edit 编辑
  .item.baby-div
    .left-div
      %img.avatar{src: "/icon/baby_female.png"}
    .right-div
      .row-div
        %label.f14.color7.fn 宝宝姓名
        %span.f12.color6.span-desc 小凉粉
        %input.input-div#baby-name
      .row-div
        %label.f14.color7.fn 宝宝性别
        %span.f12.color6.span-desc 小姑娘
        %select.input-div#baby-gender
          %option{value: "请选择"} 请选择
          %option{value: "男"} 男
          %option{value: "女"} 女
      .row-div
        %label.f14.color7.fn 宝宝生日
        %span.f12.color6.span-desc 2016/04/05
        %input.input-div#baby-birthday{type: "date"}
      .row-div
        %a.edit.f12.color10#baby-edit 编辑
  %p.f12.color10.pt16#another-baby 还有一个宝宝?
.btn#edit-end 编辑完成

.item.add-baby-div
  %img.close-add-item{src: "/icon/close.png"}
  .left-div
    %img.avatar{src: "/icon/baby_female.png"}
  .right-div
    .row-div
      %label.f14.color7.fn 宝宝姓名
      %input.add-input-div#add-baby-name
    .row-div
      %label.f14.color7.fn 宝宝性别
      %select.add-input-div.add-gender#add-baby-gender
        %option{value: "请选择"} 请选择
        %option{value: "男"} 男
        %option{value: "女"} 女
    .row-div
      %label.f14.color7.fn 宝宝生日
      %input.add-input-div#add-baby-birthday{type: "date"}
#mobileModal.modal.fade{"aria-hidden" => "true", "aria-labelledby" => "myModalLabel", :role => "dialog", :tabindex => "-1"} 
  .modal-dialog
    .modal-content
      .modal-body
        .replace-mobile-div
          .row-div
            %label.f14.color7.fn 手机号码
            .modal-input
              %input.f12.color6#mobile
              %button.f12.color10#code 发送验证码
          .row-div.nmb
            %label.f14.color7.fn 验证码
            %input.verify-code.f12.color6
        .btn#confirm-replace 确认更换
@endsection


@section('script')
<script src= "{{ mix('/js/setting-index.js') }}"></script>
<script src= "/js/profile.js"></script>
@endsection