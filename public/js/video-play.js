$(document).ready(function(){
  (function () {
      var file_id = $(".file-id").text();
      var option = {
          "auto_play": "1",
          "file_id": file_id,
          "app_id": vodId,
          "width": 750,
          "height": 422,
          "https": 1
      };

      var barrage = [
          {"type": "content", "content": "hello world", "time": "1"},
          {"type": "content", "content": "居中显示", "time": "1", "style": "C64B03;30", "position": "center"}
      ];

      window.setTimeout(function () {
          player.addBarrage(barrage);
          console.log(2);
      }, 1000);

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
});