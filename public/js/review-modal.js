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

  $("#review-submit").click(function(){
    var score = $("input:checked").val();
    if (score == 0) {
      showMsg("请评分", "center");
      return false;
    }
    console.log(window.course_id);
    $.postJSON(
      window.review,
      {
        star: score,
        course_id: window.course_id,
        _token: window.token
      },
      function(data){
        console.log(data);
        if (data.success){
          $("#reviewModal").modal("hide");
          window.location.reload(); 
        } else {
          showMsg("服务器出错，请稍后重试", "center");
        }
      }
      );
  });

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

  $(".online-course .item").each(function(){
    var status = $(this).attr("data-status");
    var enroll = $(this).find(".hasenrolled").text();
    var _this = $(this);
    if (status != "publish") {
      _this.addClass("opt55");
      _this.click(function(e){
        e.preventDefault();
        showMsg("这节课还没有上线哦～", "center");
      });
    }
    if (!enroll) {
      _this.click(function(e){
        e.preventDefault();
        $("#confirmModal").modal("show");
      });
    }
  });


  var order = null;
  var signPackage = null;
  var cid = $(".course-id").text();
  $("#add-btn").click(function(){
    $.ajax({
      url: window.order,
      type: 'post',
      data: {
          course_id: cid,
          _token: window.token,
      },
      success: function (resp) {
          // console.log(resp);
          signPackage = resp.data;
          order=resp.data.order;
          jsBrage();
      }
    });
  });

  $("#register").click(function(){
    $.ajax({
      url: window.order,
      type: 'post',
      data: {
          course_id: cid,
          _token: window.token,
      },
      success: function (resp) {
          // alert(JSON.stringify(resp));
          if(resp.success){
            $("#confirmModal").modal("hide");
          }
          signPackage = resp.data;
          order=resp.data.order;
          jsBrage();
      }
    });
  });

  $(".refund").click(function(){
    var uuid = $(".uuid").text();
    $.ajax({
      type: 'get',
      url: window.refund.replace(/-1/, uuid),
      data: cid,
      success: function(data){
        if(data.success){
          showMsg("退款成功", "center");
        }else{
          showMsg("退款失败", "center");
        }
      }
    });
  });


  function jsBrage() {
      if (typeof WeixinJSBridge == 'undefined') {
          if (document.addEventListener) {
              document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
          } else if (document.attachEvent) {
              document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
              document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
          }
      } else {
          onBridgeReady();
      }
  }
  function onBridgeReady() {
      // alert('signPackage.timeStamp='+signPackage.timeStamp);
      WeixinJSBridge.invoke('getBrandWCPayRequest', {
          'appId': ''+signPackage.appId,
          'timeStamp': ''+signPackage.timeStamp,
          'nonceStr': ''+signPackage.nonceStr,
          'package': ''+signPackage.package,
          'signType': 'MD5', //微信签名方式：
          'paySign': ''+signPackage.sign,
      }, function (res) {
          if (res.err_msg == 'get_brand_wcpay_request:ok') {
              location.href = window.pay_finish + "?course_id=" + cid;
          } // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。

      });
  }
    
});