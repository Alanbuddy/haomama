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

  $("#edit-btn").click(function(){
    $(this).toggle();
    $("#finish-btn").toggle();
    $(".unedit-box").toggle();
    $(".edit-box").toggle();
    $("#second-row").removeClass("mt30");
    $(".text-message").removeClass("mt15");
    $("#reward-label").removeClass("vt");
    $("#book-label").removeClass("vt");

    $("#teacher-name").val($("#name-span").text());
    $("#mobile").val($("#mobile-span").text());
    $("#tencent").val($("#tencent-span").text());
    $("#mail").val($("#mail-span").text());
    $("#title").val($("#title-span").text());
    $("#tel").val($("#tel-span").text());
    $("#major").val($("#major-span").text());
    $("#remark").val($("#remark-span").text());
    $("#reward").val($("#reward-span").text());
    $("#book").val($("#book-span").text());
    $("#base").val($("#base-span").text());
    desc = $("#desc-html").text();
    editor.txt.html(desc);
  });
  
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
    var reward = $("#reward").val().trim();
    var book = $("#book").val().trim();
    var base = $("#base").val().trim();
    var desc = editor.txt.html();
    var avatar = $(".cover-path").text();
    var introduce = $("#base").val().trim();
    // console.log(introduce);
    var ret = check_input(name, mobile, avatar, introduce, desc);
    if(ret == false){
      return false;
    }

    if(!$.regex.isMobile(mobile)){
      showMsg("手机号不正确", "center");
      return false;
    }
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
      award: reward,
      major: major,
      title: title,
      remark: remark,
      introduction: desc,
      basicIntroduction: introduce,
      telephone: tel,
    };
    description = JSON.stringify(description);
    var teacher_id = $(".teacher-id").text();
    var put = "PUT";
    $.ajax({
      type: "post",
      url: window.teacher_update,
      data:{
        description: description,
        name: name,
        phone: mobile,
        email: mail,
        avatar: avatar,
        _token: window.token,
        _method: put
      },
      success: function(data){
        console.log(data);
        if(data.success){
          var str = window.teacher_show.substring(0, window.teacher_show.length - 2);
          location.href = str + teacher_id + "?type=teacher";
        }
      }
      });
  });
    
  $("#course").click(function(){
    var teacher_id = $(".teacher-id").text();
    location.href = window.teacher_course.replace(/-1/, teacher_id);
  });


  $("#delete-btn").click(function(){
    var del = "DELETE";
    $.ajax({
      type: "post",
      url: window.teacher_del,
      data: {
        _token: window.token,
        _method: del
      },
      success: function(data){
        if(data.success){
          location.href = window.teacher_index;
        }else{
          showMsg("该教师不可以删除", "center");
        }
      }
    });
  });

});