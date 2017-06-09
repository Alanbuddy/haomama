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
	  $.postJSON(
	  	'/show',  //interface
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
	  		} else {
	  			if (data.code == USER_EXIST) {
	  				showMsg('该手机号已存在', 'center');
	  				return false;
	  			}
	  		}
	  	}
	  );
    return false;
	});

  $('#edit-end').click(function(){
    var parent = $('#parent').val();
    var mobile = $('#mobile').val();
    var code = $('#mobile-code').val();
    var baby_name = [];
    var gender = [];
    var birthday = [];
    $('.baby-name:visible').each(function(i){
       baby_name[i] = $(this).val();
    });
    $('.gender:visible').each(function(i){
       gender[i] = $(this).val();
    });
    $('.birthday:visible').each(function(i){
       birthday[i] = $(this).val();
    });
    console.log(baby_name);
    console.log(gender);
    console.log(birthday);
    $.postJSON(
      url,
      {
        parent: parent,
        mobile: mobile,
        code: code,
        baby_name: baby_name,
        gender: gender,
        birthday: birthday
      },
      function(data) {
        if (data.success) {
          $('#profileModal').modal('hide');
        } else {
          if (data.code == WRONG_CODE) {
            showMsg('验证码错误', 'center');
          }
        }
      }  
      );
  });
});