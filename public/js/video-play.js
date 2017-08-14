$(document).ready(function(){
  (function () {
      var file_id = $(".file-id").text();
      var option = {
          "auto_play": "1",
          "file_id": file_id,
          "app_id": vodId,
          "width": 750,
          "height": 422,
          "https": 1,
          "remember": 1
      };
      function addBarrage(barrage) {
        console.log(barrage);
        var $container = $('[component="center_container"]').parent();
        var $div = $('<div>').addClass('barrage');
        if (barrage.style) {
          $div.css('color', barrage.style.split(';')[0]);
        }
        $div.text(barrage.content);
        $container.append($div).css('overflow', 'hidden');
        $div.animate({left: '-' + $div.width() + 'px'}, 50000, 'linear').queue(function (next) {
          $(this).hide();
          next();
        });
      }
      var barrage = [
        {"type": "content", "content": "hello world", "time": "1"},
        {"type": "content", "content": "居中显示", "time": "1", "style": "C64B03;30", "position": "center"}
      ];

      
      // var barrage = [
      //     {"type": "content", "content": "hello world", "time": "1"},
      //     {"type": "content", "content": "居中显示", "time": "1", "style": "C64B03;30", "position": "center"}
      // ];

      // window.setTimeout(function () {
      //     player.addBarrage(barrage);
      // }, 1000);

      var listener = {
        playStatus: function (status){
          console.log(status);
          if (status == "seeking") {
            var time = null;
            if (player.getCurrentTime()) {
              time = player.getCurrentTime();
              console.log(time);
              var data = {
                time: time,
                video_id: window.video_id
              };
              $.postJSON(
                window.behavior,
                {
                  type: "video.drag.begin",
                  data: JSON.stringify(data),
                  _token: window.token
                },
                function(data){
                  console.log(data);
                }
                );
            }
          }
          if (status == "playing") {
            $.each(barrage, function (k, v) {
              window.setTimeout(function () {
                addBarrage(v);
              }, 1000 * (k + 1));
            });

            var drag_time = null;
            if (player.getCurrentTime()) {
              drag_time = player.getCurrentTime();
              console.log(drag_time);
              var data1 = {
                time: drag_time,
                video_id: window.video_id
              };
              $.postJSON(
                window.behavior,
                {
                  type: "video.drag.end",
                  data: JSON.stringify(data1),
                  _token: window.token
                },
                function(data){
                  console.log(data);
                }
                );
            } else {
              $.postJSON(
                window.behavior,
                {
                  type: "video.play",
                  data: JSON.stringify(window.video_id),
                  _token: window.token
                },
                function(data){
                  console.log(data);
                }
                );
            }
          }
        }
      };
      if(file_id){
        player = new qcVideo.Player("id_video_container", option, listener);
      }else{
        console.log("file_id不存在");
      }
  })();
  //播放退出监听
  window.onunload = function(){
    var video_time = player.getCurrentTime();
    alert(video_time);
  };

  

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

  $("#delivery").click(function(){
    var content = $(".review-input").val();
    var course_id = $(".course-id").attr("data-id");
    var lesson_id = $(".lesson-id").attr("data-id");
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
              template.appendTo($(".hot-review-div .review-items-div"));
            }
          }
        }
      }
    );
  });
  

  
});