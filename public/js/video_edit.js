$(document).ready(function(){

  var $list = $("#thelist");
  var $btn = $('#ctlBtn');
  var uploader = WebUploader.create({

      // swf文件路径
    swf: '/js/plugin/Uploader.swf',

    // 文件接收服务端。
    server: window.video,

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
      _token: window.token
    };

  var name = null;

  uploader.on( 'fileQueued', function( file ) {
    $("#old-video").remove();
    $list.append( '<div id="' + file.id + '" class="item">' +
        '<h4 class="info">' + file.name + '</h4>' +
        '<p class="state">等待上传...</p>' +
        '<button class="delete_btn">删除</button>' +
    '</div>' );
    name = file.name;
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
    var video_file = uploader.getFiles();
    var video_size = video_file[0].size;
    var chunksize = 0.5*1024*1024;
    var chunks = Math.ceil(video_size / chunksize);
    var video_id = $(".video-id").text();
    console.log(chunks);
    $.postJSON(
      window.merge,
      {
        _token: window.token,
        name: name,
        count: chunks,
        video_id: video_id
      },
      function(data){
        console.log(data);
        if(data.success){
          // $(".video-id").text(data.data.id);
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

  var title = $("#input-caption").val();

  $btn.click(function(){
    $.getJSON(
      window.init,
      {},
      function(data){
        console.log(data);
        if(data.success){
          $(".video-id").text(data.data.id);
          uploader.options.formData = {
              video_id: data.data.id,
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

  $(".delete_btn").click(function(){
    $(this).closest('.item').remove();
  });

  var E = window.wangEditor;
  var editor = new E('#edit-box');
  
  editor.customConfig.uploadImgServer = window.fileupload;
  editor.customConfig.showLinkImg = false;
  editor.customConfig.menus = [
        'head',
        'image'
     ];
  editor.customConfig.uploadHeaders = {
    'Accept' : 'HTML'
  };
  editor.create();

  $("#edit-btn").click(function(){
    $(this).toggle();
    $("#finish-btn").toggle();
    $(".unedit-box").toggle();
    $(".edit-box").toggle();
    $(".edit-box-uploader").css({"opacity":1, "filter": "Alpha(opacity=0)", "position": "relative"});
    $("#input-caption").val($("#caption-span").text());
    var desc = $("#desc-span").text();
    editor.txt.html(desc);
  });

  $("#finish-btn").click(function(){
    var lesson_name = $("#input-caption").val().trim();
    var lesson_video_id = $(".video-id").text();
    console.log(lesson_video_id);
    var lesson_desc = editor.txt.html();
    var put = "PUT";
    $.ajax({
      type: "post",
      url: window.lesson_update,
      data: {
        name: lesson_name,
        video_id: lesson_video_id,
        description: lesson_desc,
        _token: window.token,
        _method: put
      },
      success: function(){
        console.log(data);
        if(data.success){
          var str = window.admin_lesson_show.substring(0, window.admin_lesson_show.length - 2);
          var lid = data.data.id;
          location.href = str + lid + "?type=video";
        }
      }
    });
  });
});