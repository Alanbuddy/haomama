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

  var file_name = null;
  uploader.on( 'fileQueued', function( file ) {
    $list.append( '<div id="' + file.id + '" class="item">' +
        '<h4 class="info">' + file.name + '</h4>' +
        '<p class="state">等待上传...</p>' +
        '<button class="delete_btn">删除</button>' +
    '</div>' );
    file_name = file.name;
  });

  uploader.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#'+file.id ),
      $percent = $li.find('.progress .progress-bar');

    // 避免重复创建
    if ( !$percent.length ) {
      $percent = $('<div class="progress progress-striped active">' +
        '<div class="progress-bar" role="progressbar" style="width: 0%">' +
        '</div>' +
      '</div>').appendTo( $li ).find('.progress-bar');
    }

    $li.find('p.state').text('上传中');

    $percent.css( 'width', percentage * 100 + '%' );
  });

  uploader.on( 'uploadSuccess', function( file ) {
    $( '#'+file.id ).find('p.state').text('已上传');
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
              audio_id: data.data.id,
              _token: window.token
            };
          uploader.upload();
        }
      }
      );
  });

  $("#thelist").on("click", ".delete_btn", function(){  
    uploader.removeFile($(this).closest(".item").attr("id"));    //从上传文件列表中删除  

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
    // chunked: true,     //是否要分片处理大文件上传
    // chunkSize: 0.5*1024*1024    //分片上传，每片1M，默认是5M
  });

  uploader_img.on( 'fileQueued', function( file ) {
    $list_img.append( '<div id="' + file.id + '" class="pre_img">' +
        '<p class="img_wrap"><img></p>' +
        '<h4 class="info_img">' + file.name + '</h4>' +
        '<p class="state_img">等待上传...</p>' +
        '<img src="/icon/admin/rubbish.png" class="delete_img">' +
        '<span class="data-id"></span>' +
        '<input class="img_time" placeholder="请输入时间">' +
    '</div>' );
    $img = $("#"+ file.id).find('.img_wrap').find("img");

    uploader_img.makeThumb(file, function(error, src) {
      if (error) {
        $img.replaceWith('<span>不能预览</span>');
        return;
      }
      $img.attr('src', src);
    }, 100, 100);
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
  editor.customConfig.uploadImgServer = '/upload' ;
  editor.customConfig.showLinkImg = false;
  editor.customConfig.menus = [
        'head',
        'image'
     ];
  editor.customConfig.uploadHeaders = {
    'Accept' : 'HTML'
  };
  editor.create();

  $(document).on('click', '#finish-btn', function(){
    var img_data = [];
    var img_item = {};
    $(".pre_img").each(function(){
      var id = $(this).find('.data-id').text();
      var time = $(this).find('.img_time').val();
      img_item = {
        file: id,
        time: time
      };
      img_data.push(img_item);
    });
    console.log(img_data);
    var title = $("#input-caption").val();
    var desc = editor.txt.html();
    console.log(title);
  });

});