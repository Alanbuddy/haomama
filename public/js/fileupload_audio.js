$(document).ready(function(){
  var $list = $("#thelist");
  var $btn = $('#ctlBtn');
  var uploader = WebUploader.create({

      // swf文件路径
    swf: '/js/plugin/Uploader.swf',

    // 文件接收服务端。
    server: "/haml?m=upload",

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

  uploader.options.formData = {
      _token: window.token,
    };
  uploader.on( 'fileQueued', function( file ) {
    $list.append( '<div id="' + file.id + '" class="item">' +
        '<h4 class="info">' + file.name + '</h4>' +
        '<p class="state">等待上传...</p>' +
        '<button class="delete_btn">删除</button>' +
    '</div>' );
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
  });

  uploader.on( 'uploadError', function( file ) {
    $( '#'+file.id ).find('p.state').text('上传失败');
  });

  uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').fadeOut();
  });

  var title = $("#input-caption").val();

  $btn.click(function(){
    uploader.upload();
  });

  $("#thelist").on("click", ".delete_btn", function(){  
    uploader.removeFile($(this).closest(".item").attr("id"));    //从上传文件列表中删除  

    $(this).closest(".item").remove();   //从上传列表dom中删除  
  }); 


  var $list_img = $("#imglist");
  var $imgdiv = $(".img-div");
  var uploader_img = WebUploader.create({

      // swf文件路径
    swf: '/js/plugin/Uploader.swf',

    // 文件接收服务端。
    server: "/haml?m=upload",

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#picker_img',

    // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
    resize: false,
    auto: false,
    dnd: ".img-div",
    disableGlobalDnd: true,
    // fileNumLimit: 1,   //限制只能上传一个文件

    // chunked: true,     //是否要分片处理大文件上传
    // chunkSize: 0.5*1024*1024    //分片上传，每片1M，默认是5M
  });

  var name = [];

  uploader_img.on( 'fileQueued', function( file ) {
    $list_img.append( '<div id="' + file.id + '" class="pre_img">' +
        '<p class="img_wrap"><img></p>' +
        '<h4 class="info_img">' + file.name + '</h4>' +
        '<p class="state_img">等待上传...</p>' +
        '<img src="/icon/admin/rubbish.png" class="delete_img">' +
        '<input class="img_time" placeholder="请输入时间">' +
    '</div>' );
    name = file.name;
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

    $li.find('p.state').text('上传中');

    $percent.css( 'width', percentage * 100 + '%' );
  });

  uploader_img.on( 'uploadSuccess', function( file ) {
    $( '#'+file.id ).find('p.state').text('已上传');
  });

  uploader_img.on( 'uploadError', function( file ) {
    $( '#'+file.id ).find('p.state').text('上传失败');
  });

  uploader_img.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').fadeOut();
  });

  var img_time = [];

  $("#imgBtn").click(function(){
    $(".img_time").each(function(){
      img_time.push($(this).val());
    });
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

});