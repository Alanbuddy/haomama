
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
          an.removeClass('common').addClass('unopen');
          an.click(function(e){
            e.preventDefault();
            showMsg("这节课还没有上线哦～", "center");
          });
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

  // //需要与后台商量 决定提交lesson-id 还是course-id
  // var order = null;
  // var signPackage = null;
  // // var lid = $(".lesson-id").attr("data-id");
  // var cid = $(".course-id").attr("data-id");
  // $("#register").click(function(){
  //   $.ajax({
  //     url: window.order,
  //     type: 'post',
  //     data: {
  //         course_id: cid,
  //         _token: window.token,
  //     },
  //     success: function (resp) {
  //         // alert(JSON.stringify(resp));
  //         if(resp.success){
  //           $("#confirmModal").modal("hide");
  //         }
  //         signPackage = resp.data;
  //         order=resp.data.order;
  //         jsBrage();
  //     }
  //   });
  // });

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

          template.find(".review-name").text(data.data['user']['name']);
          template.attr("data-url", window.comment_id.replace(/-1/, data.data['item']['id']));
          template.find(".review-avatar").attr("src", data.data['user']['avatar'] ? data.data['user']['avatar']: "icon/avatar.png");
          template.find(".review-content").text(data.data['item']['content']);
          template.find(".review-source").text($(".name").text());
          template.find(".admire-num").text("0");
          template.find(".admire-icon").attr({"src": "icon/like1_normal.png", "data-ad": false});
          var data_time = data.data['item']['created_at'];
          var dtime = Date.parse(data_time);
          var dt = new Date(dtime);
          var dy = dt.getFullYear();
          var dm = dt.getMonth() + 1;
          var dd = dt.getDate();
          var time_now = Date.parse(Date());
          var tem_time = (time_now - dtime)/1000;
          if(tem_time < 60){
            template.find(".time").text( tem_time + "秒前");
          }else if (60 < tem_time && tem_time  < 3600){
            template.find(".time").text(Math.round(tem_time/60) + "分前");
          }else if (3600 < tem_time && tem_time <  86400){
            template.find(".time").text(Math.round(tem_time/3600) + "小时前");
          }else if (86400 < tem_time && tem_time  < 604800){
            template.find(".time").text(Math.round(tem_time/86400) + "天前");
          }else{
            template.find(".time").text(dy + "年" + dm + "月" + dd + "日");
          }
          if($(".feed-review-items-div")){
            template.insertBefore($(".feed-review-items-div .review-item").eq(0));
          }else{
            if($(".hot-review-div .review-item").eq(0)){
              template.insertBefore($(".hot-review-div .review-item").eq(0));
            }else{
              template.insertBefore($(".hot-review-div .review-items-div .undiscover"));
              $(".hot-review-div").find(".undiscover").hide();
            }
          }
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
    template.attr("data-url", window.comment_id.replace(/-1/, item['id']));
    template.find(".review-avatar").attr("src", item['user']['avatar'] ? item['user']['avatar']: "icon/avatar.png");
    template.find(".review-content").text(item['content']);
    template.find(".review-source").text(item['lesson']['name']);
    template.find(".admire-num").text(item['voteCount']);
    if(item['hasVoted'] == false){
      template.find(".admire-icon").attr({"src": "icon/like1_normal.png", "data-ad": false});
    }else{
      template.find(".admire-icon").attr({"src": "icon/like1_selected.png", "data-ad": true});
    }
    var data_time = item['created_at'];
    var dtime = Date.parse(data_time);
    if(isNaN(dtime)){
      dtime = Date.parse(data_time.replace(/-/g, "/"));
    }
    var dt = new Date(dtime);
    var dy = dt.getFullYear();
    var dm = dt.getMonth() + 1;
    var dd = dt.getDate();
    var time_now = Date.parse(Date());
    var tem_time = parseInt(time_now - dtime)/1000;
    if(tem_time < 60){
      template.find(".time").text( tem_time + "秒前");
    }else if (60 < tem_time && tem_time  < 3600){
      template.find(".time").text(Math.round(tem_time/60) + "分前");
    }else if (3600 < tem_time && tem_time <  86400){
      template.find(".time").text(Math.round(tem_time/3600) + "小时前");
    }else if (86400 < tem_time && tem_time  < 604800){
      template.find(".time").text(Math.round(tem_time/86400) + "天前");
    }else{
      template.find(".time").text(dy + "年" + dm + "月" + dd + "日");
    }
    return template.clone(true);
  }
  var node = "";
  function  callbackHandle(data){
    for(var i=0;i<data.data.length;i++){
      node=render(data.data[i]);
      node.insertBefore($(".main-div:visible").find(".load"));
    }
  }
  var page = 2;
  $(window).scroll(function(){
    var scrollTop = $(this).scrollTop();
    var scrollHeight = $(document).height();
    var windowheight = $(this).height();
    if(scrollTop + windowheight >= scrollHeight){
      $(".loading").show();
      $.ajax({
        type: 'get',
        url: window.upload_review + "?page=" + page,
        success: function(data){
          $(".loading").hide();
          var len = data.data.length;
          if(len > 0){
            page++;
            callbackHandle(data);
          }else{
            $(".loading").hide();
            $(".notice").show();
          }
        }
      });
    }
  });

});
