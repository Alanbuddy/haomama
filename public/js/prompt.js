
$(document).ready(function($){
  function check_status(){
    var enroll = window.enroll;
    var img = $("<img class='free-icon' src= 'icon/free.png'>");
    $(".nums-div a:eq(0)").find("span").before(img);
    if (!enroll) {
      $(".nums-div a:eq(0)").addClass("red-border");
      $(".nums-div a:gt(0)").addClass("unopen").click(function(e){
         e.preventDefault();
         $("#confirmModal").modal("show");
      });
    } else {
      $(".nums-div a").each(function(){
        var status = $(this).attr("data-status");
        var  an = $(this);
        if (status != "publish") {
          an.addClass('unopen');
        }
      });
    }
    $(".nums-div a").each(function(){
      var newest = $(this).attr("data-newest");
      var new_img = $("<img class='new-icon' src= 'icon/new.png'>");
      if (newest == true) {
        $(this).find("span").before(new_img);
      }
    });
  }
	check_status();

	$("#confirmModal").on("touchmove", function(event){
		event.preventDefault();
	});

  //需要与后台商量 决定提交lesson-id 还是course-id
  var order = null;
  var signPackage = null;
  // var lid = $(".lesson-id").attr("data-id");
  var cid = $(".course-id").attr("data-id");
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

  $("#delivery").click(function(){
    var content = $(".review-input").val();
    var course_id = $(".course-id").attr("data-id");
    var lesson_id = $(".lesson-id").attr("data-id");
    console.log(content);
    console.log(course_id);
    console.log(lesson_id);
    $.postJSON(
      window.comment,
      {
        content: content,
        course_id: course_id,
        lesson_id: lesson_id,
        _token: window.token
      },
      function(data){
        console.log(data);
        if (data.success){
          $(".review-input").val("");
          showMsg("评论完成", "center");
        }
      }
    );
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

  var pictures = [];
  var pic_item = {};
  $(".picture-item").each(function(){
    var pic = $(this).find(".picture").text();
    var pic_time = $(this).find(".picture-time").text();
    pic_item = {
      src: pic,
      time: parseInt(pic_time)
    };
    pictures.push(pic_item);
  });
  
  var timer = null;
  var audio = document.querySelector("#audio");
  audio.addEventListener("play", function(){
    timer = setInterval(function(){
      $(".audio-poster").attr("src", "icon/banner.png");
    }, 1000);
  });



});
