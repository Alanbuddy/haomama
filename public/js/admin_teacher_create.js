$(document).ready(function(){
	var E = window.wangEditor;
  var editor = new E('#edit-area');
  editor.customConfig.uploadImgParams = {
      _token: window.token,
      editor: "1"
  };
  editor.customConfig.uploadFileName = 'file';
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
    var major = $("#major").val().trim();
    var remark = $("#remark").val().trim();
    var award = $("#award").val().trim();
    var book = $("#book").val().trim();
    var introduce = $("#base").val().trim();
    var desc = editor.txt.html(); 
    var avatar = $(".cover-path").text();
    
    var ret = check_input(name, mobile, avatar, introduce, desc);
    if(ret == false){
      return false;
    }
    console.log(desc);
    if(!$.regex.isMobile(mobile)){
      showMsg("手机号不正确", "center");
      return false;
    }
    //需要时再放开
    // if(!$.regex.isEmail(mail)){
    //   showMsg("邮箱输入不正确", "center");
    //   return false;
    // }
    // if(!$.regex.isPhone(tel)){
    //   showMsg("座机号输入不正确", "center");
    //   return false;
    // }
    var description = {
      qq: tencent,
      book: book,
      award: award,
      major: major,
      title: title,
      remark: remark,
      introduction: desc,
      basicIntroduction: introduce,
      telephone: tel,
    };
    description = JSON.stringify(description);
    $.postJSON(
      window.teacher_store + "?type=teacher",
      {
        description: description,
        name: name,
        phone: mobile,
        email: mail,
        avatar: avatar,
        _token: window.token
      },
      function(data){
        console.log(data);
        if(data.success){
          var tid = data.data.id;
          var str = window.teacher_show.replace(/-1/, tid);
          location.href = str + "?type=teacher";
        }
      }
      );
  });


});