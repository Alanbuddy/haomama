$(document).ready(function(){
  var $list = $("#thelist");
  var $btn = $("#ctlBtn");
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
    // fileNumLimit: 1,   //限制只能上传一个文件

    // chunked: true,     //是否要分片处理大文件上传
    // chunkSize: 0.5*1024*1024    //分片上传，每片1M，默认是5M
  });

  uploader.options.formData = {
      _token: window.token
    };

  var name = null;
  uploader.on( 'fileQueued', function( file ) {
    $list.append( '<div id="' + file.id + '" class="item">' +
        '<img class="edit-img-item">' +
        '<img class="delete" src="icon/admin/delete2.png">' +
        '<h4 class="info">' + file.name + '</h4>' +
        '<p class="path"></p>' +
        '<p class="state">等待上传...</p>' +
    '</div>' );
    name = file.name;
    $img = $("#"+ file.id).find('.edit-img-item');
    uploader.makeThumb(file, function(error, src) {
      if (error) {
        $img.replaceWith('<span>不能预览</span>');
        return;
      }
      $img.attr('src', src);
    }, 750, 320);
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

  uploader.on( 'uploadSuccess', function( file, rseponse ) {
    $( '#'+file.id ).find('p.state').text('已上传');
    showMsg("上传成功","center");
    $( '#'+file.id ).find('p.path').text(rseponse.data.path);
  });

  uploader.on( 'uploadError', function( file ) {
    $( '#'+file.id ).find('p.state').text('上传失败');
  });

  uploader.on( 'uploadComplete', function( file ) {
    $( '#'+file.id ).find('.progress').fadeOut();
  });


  $btn.click(function(){
    uploader.upload();
  });

  $("#thelist").on("click", ".delete", function(){  
    uploader.removeFile($(this).closest(".item").attr("id"));    //从上传文件列表中删除  

    $(this).closest(".item").remove();   //从上传列表dom中删除  
  }); 

 

  $("#edit-btn").click(function(){
    $(this).toggle();
    $("#finish-btn").toggle();
    $(".unedit-box").toggle();
    $(".edit-box").toggle();
    uploader.refresh();
  });
  
  $(".delete").click(function(){
    $(this).closest(".item").remove();
  });

  $("#course").click(function(){
    location.href = window.set_recommend;
  });

  $("#announce").click(function(){
    location.href = window.img_index;
  });

  $(document).on('click', '#finish-btn', function(){
    var name = "carousel";
    var value = [];
    $(".item").each(function(){
      value.push($(this).find(".path").text());
    });
    console.log(value);
    $.ajax({
      url: window.img_store,
      type: 'post',
      data: {
        key: name,
        value: JSON.stringify(value),
        _token: window.token
      },
      success: function(data){
        if(data.success){
          location.href = window.img_index;
        }
      }
    });
  });
});