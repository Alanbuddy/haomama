@extends('layout.app')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/setting-create.css') }}">
@endsection

@section('content')
.head-div
  %p.fb.tc.fb.color7.f18 个人资料
  %img.profile-close{src: "/icon/close.png"}
.item-div 
  .item
    .left-div
      %img.avatar{src: "/icon/avatar.png"}
    .right-div
      .row-div
        %label.f14.color7.fn 家长身份
        %select.input-div#parent
          %option{value: "请选择"} 请选择
          %option{value: "爸爸"} 爸爸
          %option{value: "妈妈"} 妈妈
      .row-div
        %label.f14.color7.fn 手机号码
        .mobile-div
          %input.f12.color6#mobile
          %span.f12.color10#code 验证码
      .row-div
        %label.f14.color7.fn 验证码
        %input.input-div.f12.color6
  .item.baby-div
    .left-div
      %img.avatar{src: "/icon/baby_female.png"}
    .right-div
      .row-div
        %label.f14.color7.fn 宝宝姓名
        %input.input-div#baby-name
      .row-div
        %label.f14.color7.fn 宝宝性别
        %select.input-div#baby-gender
          %option{value: "请选择"} 请选择
          %option{value: "男"} 男
          %option{value: "女"} 女
      .row-div
        %label.f14.color7.fn 宝宝生日
        %input.input-div#baby-birthday{type: "date"}
  %p.f12.color10.pt16#another-baby 还有一个宝宝?
.btn#edit-end 编辑完成
@endsection

@section('script')
<script src= "{{ mix('/js/setting-create.js') }}"></script>
@endsection