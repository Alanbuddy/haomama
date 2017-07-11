@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/user-profile.css') }}">
:javascript
    // window.course_index = "#{route('courses.index')}"
    // window.course_create = "#{route('courses.create')}"
    // window.logout = "#{route('logout')}"
    // window.login = "#{route('login')}"
    // window.token = "#{csrf_token()}"
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
              // = form_tag("/staff/accounts/" + @current_user.id.to_s, method: "put", multipart: true, id: "upload-photo-form", class: "person-div") do
              //   = file_field_tag "photo_file", { class: "hide", accept: ".jpg,.png" }
              //   .photo-div
              //     %a.upload-div#upload-photo{href: "#"}
              //       %img.bg2.photo#figure-photo{ src:"/icon/admin/default.png"}
              //     %img.fingure{src: "/icon/admin/photo.png"}
                %input#previewImg{:onchange => "previewImage(this)", :type => "file", style: "display:none;"}
                .photo#preview
                  %img.edit-photo#imghead{src: "/icon/admin/photo.png", onclick: "$('#previewImg').click()"}
                %p.mobile
                  %span.f20.font-color3.mobile-num 手机号:
                  %span.f20.font-color3 13232344345
                %p
                  %span.f20.font-color3.name 姓名:
                  %input.form-control.font-color3#user_name{placeholder: "请输入姓名", value: ""}

@endsection

@section('script')
<script src="/js/preview.js"></script>
<script src= "/js/admin-user-profile.js"></script>


@endsection