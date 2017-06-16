$(document).ready(function($) {
	var timer = null;
	var wait = 60;
	var time = function(o){
		$(o).attr('disabled', true);
		if (wait == 0){
			$(o).attr('disabled', false);
			$(o).text('发送验证码');
			wait = 60;
		} else {
			$(o).text('重发(' + wait + ')');
			wait--;
			timer = setTimeout(function(){
				time(o);
				return false;
			}, 1000);
		}
		return false;
	};

	$("#review-btn").click(function(){
	    $("#reviewModal").modal("show");
	  });
	$('#reviewModal').on('touchmove', function(event) {
	    event.preventDefault();
	});
	$("#test-btn").click(function(){
	    $("#profileModal").modal("show");
	  });
	$('.profile-close').click(function(){
	    $("#profileModal").modal("hide");
	    $('.add-baby-div').hide();
	});
	$("#code").click(function(){
	  var mobile = $("#mobile").val();
	  var mobile_retval = $.regex.isMobile(mobile);
	  if (mobile_retval === false) {
	    showMsg("手机号不正确", 'center');
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

  $('#edit-end').click(function(){
    var parent = $('#parent').val();
    var mobile = $('#mobile').val();
    var code = $('#mobile-code').val();
    var baby = [];
    var name = [];
    var gender = [];
    var birthday = [];
    console.log(parent);
    console.log(mobile);
    console.log(code);
    $(".baby-item:visible").each(function(i){
      name[i] = $(this).find(".baby-name:visible").val();
      gender[i] = $(this).find(".gender:visible").val();
      birthday[i] = $(this).find(".birthday:visible").val();
      baby[i] = {
        name: name[i],
        gender: gender[i],
        birthday: birthday[i]
      };
    });
    console.log(baby);
    $.getJSON(
      window.sms_verify,
      {
        mobile: mobile,
        code: code
      },
      function(data) {
        console.log(data);
        if (data.success) {
          $.postJSON(
            window.user_profile,
            {
              parenthood: parent,
              phone: mobile,
              baby: JSON.stringify(baby),
              _token: window.token 
            },
            function(data) {
              if (data.success) {
                $('#profileModal').modal('hide');
                showMsg("资料已提交", "center");
              }
              // else {
              //   if (data.code == WRONG_CODE) {
              //     showMsg('验证码错误', 'center');
              //   }
              // }
            }  
            );
        } else {
          // 需要修改
          showMsg('验证码错误', 'center');

          // if (data.message == "WRONG_VERIFY_CODE") {
          //   showMsg('验证码错误', 'center');
          // }
        }
      }
      );
  });
});