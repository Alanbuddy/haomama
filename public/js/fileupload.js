$(document).ready(function(){
  $('#upload').html5uploader({

    auto:false,

    multi:true,

    removeTimeout:9999999,

    url:window.video,

    onUploadStart:function(){

      alert('开始上传');

      },

    onInit:function(){

      // alert('初始化');

      },

    onUploadComplete:function(){

      alert('上传完成');

      }

    });

  $('#upload_img').html5uploader({

    auto:false,

    multi:true,

    removeTimeout:9999999,

    url:window.video,

    onUploadStart:function(){

      alert('开始上传');

      },

    onInit:function(){

      // alert('初始化');

      },

    onUploadComplete:function(){

      alert('上传完成');

      }

    });

});