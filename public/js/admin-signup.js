$(document).ready(function($) {
  var timer = null;
  var wait = 60;
  var time = function(o) {
    $(o).attr("disabled", true);
    if (wait == 0) {
      $(o).attr("disabled", false);
      $(o).text('获取验证码');
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
    } else {
      $.getJSON(
        window.validmobile,
        {
          phone: mobile
        },
        function(data){
          console.log(data);
          if(data.isOccupied == false){
            $.getJSON(
              window.sms_send,
              {
                mobile: mobile
              },
              function(data){
                console.log(data);
                if (data.success){
                  $("#mobile_notice").css("visibility", "hidden");
                  if (timer !== null) {
                    clearTimeout(timer);
                  }
                  time("#verifycode");
                } else {
                  $("#mobile_notice").text("请稍后再重新获取").css("visibility", "visible");
                }
              }
            );
          } else {
            $("#mobile_notice").text("该号码已经注册!").css("visibility", "visible");
            return false;
          }
        }
        );
    }
  });
  
  function toggle_password_tip(wrong) {
    if (wrong) {
      $("#password_notice").css("visibility", "visible");
    } else {
      $("#password_notice").css("visibility", "hidden");
    }
  }

  function signup(){
    if ($("#signup_btn").attr("disabled") == true) {
      return false;
    }
    var phone = $("#mobile").val();
    var verify_code = $("#mobilecode").val();
    var password = $("#password").val();
    var password_again = $("#password_again").val();
    if (password != password_again) {
      toggle_password_tip(true);
      return false;
    }
    $.ajax({
      type: 'post',
      url: window.register,
      data: {
        phone: phone,
        password: password,
        password_confirmation: password_again,
        captcha: verify_code,
        _token: window.token
      },
      async: false,
      success: function(){
        location.href = window.home_page;
      }
    });

    // $.postJSON(
    //   window.register,
    //   {
    //     phone: phone,
    //     password: password,
    //     password_confirmation: password_again,
    //     captcha: verify_code,
    //     _token: window.token
    //   },
    //   function(data){
    //     console.log(ajax.status);
    //     if (ajax.status == 302) {
    //       location.href = window.home_page;
    //     }
    //     // else
    //     //   if data.code == WRONG_VERIFY_CODE
    //     //    $("#code_notice").text("验证码错误").css("visibility", "visible")
    //     //   if data.code == USER_NOT_EXIST
    //     //     $("#mobile_notice").text("账号不存在").css("visibility", "visible")
    //   }
    //   ); 
  }

  $("#signup_btn").click(function(){
    signup();
    return false;
  });
    
  $("#password_again").keydown(function(event){
    var code = event.which;
    if (code == 13){
      signup();
    }
  });
    
});