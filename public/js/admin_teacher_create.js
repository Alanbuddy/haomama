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

  function check_input(name, mobile, avatar, introduce, desc){
    if(name == "" || mobile == "" || avatar == "" || introduce == "" || desc == ""){
      showMsg("有必填项内容没有填写", "center");
      return false;
    }
  }
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
    var avatar = $(".cover-path").text();

    var ret = check_input(name, mobile, avatar, introduce, desc);
    if(ret == false){
      return false;
    }

    $.postJSON(
      window.teacher_store,
      {
        
      },
      function(data){
        console.log(data);
      }
      );
  });


});