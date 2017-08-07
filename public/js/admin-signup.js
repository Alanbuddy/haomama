$(document).ready(function() {
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
    var mobile = $("#mobile").val().trim();
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
                phone: mobile
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
    var phone = $("#mobile").val().trim();
    var verify_code = $("#mobilecode").val().trim();
    var password = $("#password").val().trim();
    var password_again = $("#password_again").val().trim();
    if(password.length < 6 || password_again.length < 6){
      $("#code_notice").text("密码不能小于６位").css("visibility", "visible");
      return false;
    }
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
        code: verify_code,
        _token: window.token
      },
      async: true,
      success: function(data){
        console.log(data);
        if (data.success){
          showMsg("您已注册成功，请通知管理员开通您的账号", "center");
        }else{
          $("#code_notice").css("visibility", "visible");
        }
      }
    }); 
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