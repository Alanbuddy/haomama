$(document).ready(function(){
  var $list = $("#thelist");
  var $btn = $('#ctlBtn');
  var uploader = WebUploader.create({

      // swf文件路径
    swf: '/js/plugin/Uploader.swf',

    // 文件接收服务端。
    server: window.fileupload,

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#picker',

    // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
    resize: false,
    auto: false,
    dnd: "#thelist",
    disableGlobalDnd: true,
    fileNumLimit: 1,   //限制只能上传一个文件

    chunked: true,     //是否要分片处理大文件上传
    chunkSize: 0.5*1024*1024    //分片上传，每片1M，默认是5M
  });
  // window.uploader=uploader;
  var file_name = null;
  var MIME = null;
  uploader.on( 'fileQueued', function( file ) {
    $list.append( '<div id="' + file.id + '" class="item">' +
        '<span class="info">' + file.name + '</span>' +
        '<p class="state">等待上传...</p>' +
        '<button class="delete_btn">删除</button>' +
    '</div>' );
    file_name = file.name;
    MIME = uploader.getFiles()[0].type;
  });

  uploader.on( 'uploadProgress', function( file, percentage ) {  
    $('.item').find('p.state').text('上传中 '+Math.round(percentage * 100) + '%');
    var $li = $( '#'+file.id ),
      $percent = $("#thelist").find('.progress .progress-bar');

    // 避免重复创建
    if ( !$percent.length ) {
      $percent = $('<div class="progress progress-striped active">' +
        '<div class="progress-bar" role="progressbar" style="width: 0%">' +
        '</div>' +
      '</div>').appendTo($("#thelist")).find('.progress-bar');
    }
    $percent.css( 'width', percentage * 100 + '%' );
  });

  uploader.on( 'uploadSuccess', function( file ) {
    $( '#'+file.id ).find('p.state').text('已上传' + '100%');
    $("#uploader").find(".progress").fadeOut(1000);
    var audio_file = uploader.getFiles();
    var audio_size = audio_file[0].size;
    var chunksize = 0.5*1024*1024;
    var chunks = Math.ceil(audio_size / chunksize);
    var audio_id = $(".audio-id").text();
    console.log(audio_id);
    $.postJSON(
      window.files_merge,
      {
        _token: window.token,
        name: file_name,
        count: chunks,
        file_id: audio_id
      },
      function(data){
        console.log(data);
        if(data.success){
        }
      }
      );
  });

  uploader.on( 'uploadError', function( file ) {
    $( '#'+file.id ).find('p.state').text('上传失败');
  });

  uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').fadeOut();
  });

  $btn.click(function(){
    $.getJSON(
      window.audio_init,
      {},
      function(data){
        if(data.success){
          $(".audio-id").text(data.data.id);
          uploader.options.formData = {
              file_id: data.data.id,
              _token: window.token,
              mime: MIME
            };
          uploader.upload();
        }
      }
      );
  });

  $("#thelist").on("click", ".delete_btn", function(){  
    uploader.removeFile($(this).closest(".item").attr("id"));    //从上传文件列表中删除  
    $("#uploader").find(".progress").remove();
    $(this).closest(".item").remove();   //从上传列表dom中删除  
  }); 




  var $list_img = $("#imglist");
  var $imgdiv = $(".img-div");
  var uploader_img = WebUploader.create({
    swf: '/js/plugin/Uploader.swf',
    server: window.fileupload,
    pick: '#picker_img',
    resize: false,
    auto: false,
    dnd: ".img-div",
    multiple: true,
    disableGlobalDnd: true,
    duplicate: true,
    thumb: {
      allowMagnify: false,
      quality: 70,
    },
    compress: {
      allowMagnify: false,
      quality: 90,
    }
    // chunked: true,     //是否要分片处理大文件上传
    // chunkSize: 0.5*1024*1024    //分片上传，每片1M，默认是5M
  });

  uploader_img.on( 'fileQueued', function( file ) {
    $list_img.append( '<div id="' + file.id + '" class="pre_img">' +
        '<p class="img_wrap"><img></p>' +
        '<span class="info_img">' + file.name + '</span>' +
        '<p class="state_img">等待上传...</p>' +
        '<img src="icon/admin/rubbish.png" class="delete_img">' +
        '<span class="data-id"></span>' +
        '<input class="img_time" placeholder="请输入时间hh:mm:ss" type="text">' +
    '</div>' );
    $img = $("#"+ file.id).find('.img_wrap').find("img");

    uploader_img.makeThumb(file, function(error, src) {
      if (error) {
        $img.replaceWith('<span>不能预览</span>');
        return;
      }
      $img.attr('src', src);
    }, 200, 200);
  });

  uploader_img.options.formData = {
      _token: window.token
    };

  uploader_img.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#'+file.id ),
      $percent = $li.find('.progress .progress-bar');

    // 避免重复创建
    if ( !$percent.length ) {
      $percent = $('<div class="progress progress-striped active">' +
        '<div class="progress-bar" role="progressbar" style="width: 0%">' +
        '</div>' +
      '</div>').appendTo( $li ).find('.progress-bar');
    }

    $li.find('p.state_img').text('上传中');

    $percent.css( 'width', percentage * 100 + '%' );
  });

  uploader_img.on( 'uploadSuccess', function( file, response) {
    $( '#'+file.id ).find('p.state_img').text('已上传').hide(2000);

    $('#'+file.id).find('.data-id').text(response.data.id);
  });

  uploader_img.on( 'uploadError', function( file ) {
    $( '#'+file.id ).find('p.state_img').text('上传失败');
  });

  uploader_img.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').fadeOut();
  });

  $("#imgBtn").click(function(){
    uploader_img.upload();
  });

  $("#imglist").on("click", ".delete_img", function(){  
    uploader_img.removeFile($(this).closest(".pre_img").attr("id"));    //从上传文件列表中删除  
    $(this).closest(".pre_img").remove();   //从上传列表dom中删除  
  }); 

  $("#imglist").on("mouseover", ".pre_img", function(){
    $(this).find(".delete_img").show();
  });
  $("#imglist").on("mouseout", ".pre_img", function(){
    $(this).find(".delete_img").hide();
  });

  var E = window.wangEditor;
  var editor = new E('#edit-box');
  editor.customConfig.uploadImgParams = {
      _token: window.token,
      editor: "1"
  };
  editor.customConfig.uploadFileName = 'file';
  editor.customConfig.uploadImgServer = window.fileupload ;
  editor.customConfig.showLinkImg = false;
  editor.customConfig.menus = [
        'head',
        'image'
     ];
  editor.customConfig.uploadHeaders = {
    'Accept' : 'HTML'
  };
  editor.create();

  function check_time(time){
    if(time > 60){
      return false;
    }
  }

  $(document).on('click', '#finish-btn', function(){
    var img_data = [];
    var img_item = {};
    var valid_time = null;
    $(".pre_img").each(function(){
      var id = $(this).find('.data-id').text();
      var time = $(this).find('.img_time').val().trim().split(":");
      for(var i=0;i<time.length;i++){
        valid_time = check_time(time[i]);
        if(valid_time == false){
          break;
        }
      }
      if(time.length == 3){
        time = parseInt(time[0]*3600) + parseInt(time[1] * 60) + parseInt(time[2]);
      }else if(time.length == 2){
        time =parseInt(time[0] * 60) + parseInt(time[1]);
      }else if(time.length == 1){
        time =parseInt(time[0]);
      }else{
        showMsg("输入格式不正确", "center");
        return false;
      }
      img_item = {
        file: id,
        time: time
      };
      img_data.push(img_item);
    });
    if(valid_time == false){
      showMsg("输入时间格式不正确", "center");
      return false;
    }
    var title = $("#input-caption").val();
    var desc = editor.txt.html();
    var video_id = $(".video-id").text();
    var audio_id = $(".audio-id").text(); 
    if (title == "" || audio_id == "" || desc == "" || img_data.length == 0){
      showMsg("每一项都必须填写", "center");
      return false;
    }

    var input_time = [];
    $(".img_time").each(function(){
      var imgTime = $(this).val().trim();
      input_time.push(imgTime);
    });
    for(var i=0;i<input_time.length;i++){
      if(input_time[i] == ""){
        showMsg("每一项播放时间都必须填写", "center");
        return false;
      }
    }
    $.ajax({
      type: 'post',
      url: window.lesson_store + "?type=audio",
      data: {
        video_id: video_id,
        name: title,
        audio: audio_id,
        description: desc,
        pictures: img_data,
        _token: window.token
      },
      success: function(data){
        if(data.success){
          var lid = data.data;
          var str = window.admin_lesson_show.replace(/-1/, lid);
          location.href = str + "?type=audio";
        }
      },
      error: function(xhr, status,error){
        if(xhr.status == 422){
          showMsg("课时名称不可以重复", "center");
          return false;
        }
      }
    });
  });
 
});