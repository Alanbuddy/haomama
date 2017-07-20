$(document).ready(function(){
	var E = window.wangEditor;
  var editor = new E('#edit-area');
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

  $("#finish-btn").click(function(){
    var name = $("#teacher-name").val().trim();
    var mobile = $("#mobile").val().trim();
    var tencent = $("#tencent").val().trim();
    var mail = $("#mail").val().trim();
    var title = $("#title").val().trim();
    var tel = $("#tel").val().trim();
    var prefer = $("#prefer").val().trim();
    var remark = $("#remark").val().trim();
    var reward = $("#reward").val().trim();
    var book = $("#book").val().trim();
    var introduce = $("#base").val().trim();
    var desc = editor.txt.html(); 
  });


});