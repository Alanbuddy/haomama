$(document).ready(function(){

  var barrage = [];
  var bar_item = {};
  $(".review-content").each(function(){
    var comment_content = $(this).text();
    if(comment_content.length < 15){
      bar_item = {
        "type": "content",
        "content": comment_content,
        "time": "1"
      };
    }
    barrage.push(bar_item);
  });

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
        var $video_div = $(".video-div");
        var $div = $('<div>').addClass('barrage');
        if (barrage.style) {
          $div.css('color', barrage.style.split(';')[0]);
        }
        $div.text(barrage.content);
        $video_div.append($div).css('overflow', 'hidden');
        $div.animate({left: '-' + $div.width() + 'px'}, 2500, 'linear').queue(function (next) {
          $(this).hide() ;
          next();
        });
      }
      
      //pc端用下面的代码实现弹幕
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
  
});