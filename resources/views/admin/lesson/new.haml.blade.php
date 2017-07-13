@extends('layout.admin')
@section('css')
<link rel="stylesheet" href="{{ mix('/css/admin-lesson-new.css') }}">
// <link href="/css/plugin/upload/jquery.fileupload.css" rel="stylesheet" type="text/css">
// <link href="/css/plugin/upload/jquery.fileupload-ui.css" rel="stylesheet" type="text/css">
// <link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">

<link href="/css/plugin/html5uploader.css" rel="stylesheet" type="text/css">

:javascript
    window.lesson_index = "#{route('lessons.index')}"
    window.lesson_store = "#{route('lessons.store')}"
    window.video = "#{route('videos.store')}"
    window.token = "#{csrf_token()}"
@endsection

@section('content')
.content-area
  .main-top.direction
    %a{href: route('lessons.index')}
      %img.back{src: "/icon/admin/back.png"}
    %ul.set
      %li
        %a.f16{href: route('users.index')} 人员管理
        .dot
      %li
        %a.f16.left-border{href: route('admin.profile')} 账号设置
      %li
        %a.f16.set-left-border#exit{href: "#"} 退出登录
    
  .main-content.bg2
    %button.btn.finish-normal.font-color1.finish-btn-position#finish-btn{type: "button"} 保存
    .table-div
      .tabbable
        %ul.nav.nav-tabs
          %li.active
            %a.f16.font-color1{"data-toggle" => "tab", :href => "#tab1"} 视频详情
        .tab-content.bg3
          #tab1.tab-pane.active
            .desc-div.font-color3.f14
              .form-group
                %label.input-name.fn 课时标题:
                %input.form-control#input-caption{:type => "text"}
              .video-file
                %span 视频文件:
                %span#upload
                
                // %input.pc-file{type: "file", style: "display: none;"} 
                // %form#fileupload{:action => "", :enctype => "multipart/form-data", :method => "POST"}
                //   .row.fileupload-buttonbar
                //     .col-lg-7
                //       %span.btn.btn-success.fileinput-button
                //         %i.glyphicon.glyphicon-plus
                //         %span 选择文件
                //         %input{:multiple => "multiple", :name => "files[]", :type => "file"}/
                //       %button.btn.btn-primary.start{:type => "submit"}
                //         %i.glyphicon.glyphicon-upload
                //         %span 开始上传
                //       %button.btn.btn-warning.cancel{:type => "reset"}
                //         %i.glyphicon.glyphicon-ban-circle
                //         %span 取消上传
                //       %button.btn.btn-danger.delete{:type => "button"}
                //         %i.glyphicon.glyphicon-trash
                //         %span 删除
                //       %span.fileupload-process
                //     .col-lg-5.fileupload-progress.fade
                //       .progress.progress-striped.active{"aria-valuemax" => "100", "aria-valuemin" => "0", :role => "progressbar"}
                //         .progress-bar.progress-bar-success{:style => "width:0%;"}
                //       .progress-extended  
                //   %table.table.table-striped{:role => "presentation"}
                //     %tbody.files

              
             
              .notice-introduce.clearfix
                %span.introduce 内容介绍:
                %span.wangedit-area
                  #edit-box

@endsection

@section('script')
<script src= "{{mix('/js/admin-lesson-new.js')}}"></script>
<script src="/js/plugin/wangEditor.min.js"></script>
<script src="/js/plugin/jquery-ui.min.js"></script>
// <script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
// <script src="/js/plugin/upload/jquery.fileupload.js"></script>
// <script src="/js/plugin/upload/jquery.fileupload-process.js"></script>
<script src="/js/plugin/jquery.js"></script>
<script src="/js/plugin/jquery.html5uploader.js"></script>

<script src="/js/fileupload.js"></script>

// <script id="template-upload" type="text/x-tmpl">
//   {% for (var i=0, file; file=o.files[i]; i++) { %}
//     <tr class="template-upload fade">
//       <td>
//         <span class="preview"></span>
//       </td>
//       <td>
//         <p class="name">{%=file.name%}</p>
//         <strong class="error text-danger"></strong>
//       </td>
//       <td>
//         <p class="size">Processing...</p>
//         <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
//       </td>
//       <td>
//         {% if (!i && !o.options.autoUpload) { %}
//           <button class="btn btn-primary start" disabled>
//             <i class="glyphicon glyphicon-upload"></i>
//             <span>Start</span>
//           </button>
//         {% } %}
//         {% if (!i) { %}
//           <button class="btn btn-warning cancel">
//             <i class="glyphicon glyphicon-ban-circle"></i>
//             <span>Cancel</span>
//           </button>
//         {% } %}
//       </td>
//     </tr>
//   {% } %}
// </script>

@endsection