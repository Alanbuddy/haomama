$(document).ready(function($) {
  var timer = null;
  var wait = 60;
  var time = function(o) {
    $(o).attr("disabled", true);
    if (wait == 0) {
      $(o).attr("disabled", false);
      $(o).text('发送验证码');
      wait = 60;
    } else {
      $(o).text('重发(' + wait + ')');
      wait--;
      timer = setTimeout(function(){
        time(o);
      }, 1000);
    }
    return false;
  };

  $("#verifycode").click(function(){
    var mobile = $("#mobile").val();
    var mobile_retval = $.regex.isMobile(mobile);
    if (mobile_retval == false) {
      $("#mobile_notice").text("请输入正确手机号").css("visibility", "visible");
      return false;
    }
    $.getJSON(
      window.sms_send,
      {
        mobile: mobile
      },
      function(data){
        console.log(data);
        if (data.success){
          if (timer !== null) {
            clearTimeout(timer);
          }
          time('#code');
        }
      }
    );
    return false;
  });
  
});