$(document).ready(function($){

  function signin(){
    if ($("#signin_btn").attr("disabled") == true) {
      return false;
    }
    var mobile = $("#mobile").val();
    var password = $("#password").val();
    var mobile_retval = $.regex.isMobile(mobile);
    if (mobile_retval == false) {
      $("#error_notice").text("手机号错误").css("visibility", "visible");
      return false;
    }
    $.postJSON(
      window.login,
      {
        email: mobile,
        password: password
      },
      function(data){
        if (data.success){
          location.href = window.course_index;
        } else {
          if (data) {
            $("#error_notice").text("帐号不存在").css("visibility","visible");
          }
          if (data) {
            $("#error_notice").text("手机号未验证").css("visibility","visible");
          }
          if (data) {
            $("#error_notice").text("密码错误").css("visibility","visible");
          }
        }
      }
      );
  }
  $("#signin_btn").click(function(){
    signin();
    return false;
  });
  $("#password").keydown(function(event) {
    var code = event.which;
    if (code == 13) {
      signin();
    }
  });

});