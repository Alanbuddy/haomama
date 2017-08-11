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

  //个人资料页的验证码和提交
	$("#code").click(function(){
	  var mobile = $("#mobile").val();
	  var mobile_retval = $.regex.isMobile(mobile);
	  if (mobile_retval === false) {
	    showMsg("手机号不正确", 'center');
	    return false;
	  }else{
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
                  if (timer !== null) {
                    clearTimeout(timer);
                  }
                  time('#code');
                }else{
                  showMsg("发送失败，请稍后重试", "center");
                }
              }
            );
          }else{
            showMsg("该手机号已注册", "center");
            return false;
          } 
        }
        );
    }
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
        phone: mobile,
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
            }  
            );
        } else {
          showMsg('验证码错误', 'center');
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

  $(".online-course .item:eq(0)").find(".free").show();

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
  
  var temp = `<div class="review-item" data-url="/comments/48/vote">
            <img class="review-avatar" src="icon/avatar.png">
            <div class="item-desc">
              <p class="f12 color7 review-name">123</p>
              <p class="f12 color5 time">5天前</p>
              <p class="f14 color7 review-content">ggggg</p>
              <span class="f12 color5">评论来源：</span>
              <span class="f12 color5 review-source">audio-test</span>
              <div class="admire-div">
                <span class="f12 color5 admire-num">1</span>
                <img class="admire-icon" src="icon/like1_selected.png" data-ad="true">
              </div>
            </div>
          </div>`;
  var template = $(temp);
  function render(item){
    template.find(".review-name").text(item['user']['name']);
    template.find(".review-avatar").attr("src", item['user']['avatar']);
    template.find(".time").text(item['created_at']);
    template.find(".review-content").text(item['content']);
    template.find(".review-source").text(item['lesson']['name']);
    template.find(".admire-num").text(item['voteCount']);
    template.find(".review-item").attr("data-url", route("comments.vote", item['id']));
    if(item['hasVoted'] == false){
      template.find(".admire-icon").attr({"src": "icon/like1_normal.png", "data-ad": false});
    }else{
      template.find(".admire-icon").attr({"src": "icon/like1_selected.png", "data-ad": true});
    }
    return template.clone(true);
  }

  function  callbackHandle(data){
    for(var i=0;i<data.data.length;i++){
      node=render(data.data[i]);
      // if(node.find('.category-class').text() ==  "健康养育"){
      //   node.find('.category-class').addClass('health-title');
      // }else if(node.find('.category-class').text() ==  "心理教育"){
      //   node.find('.category-class').addClass('psychology-title');
      // }else{
      //   node.find('.category-class').addClass('grow-title');
      // }
      node.appendTo($('.review-items-div'));
    }
  }
  var page = 2;
  $(window).scroll(function(){
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(document).height();
    var windowheight = $(this).height();
    console.log(scrollTop);
    console.log(scrollHeight);
    console.log(windowheight);
    if(scrollTop + windowheight >= scrollHeight){
      $(".loading").show();
      // alert("aaa");
      $.ajax({
        type: 'get',
        url: window.review + "?page=" + page,
        success: function(data){
          $(".loading").hide();
          console.log(data);
          var len = data.data.length;
          if(len > 0){
            page++;
            callbackHandle(data);
          }else{
            $(".notice").show();
          }
        }
      });
    }
  });
});