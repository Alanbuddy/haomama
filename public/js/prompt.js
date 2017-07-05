

$(document).ready(function($){
  function check_status(){
    var enroll = window.enroll;
    var img = $("<img class='free-icon' src= '/icon/free.png'>");
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
      var new_img = $("<img class='new-icon' src= '/icon/new.png'>");
      if (newest == true) {
        $(this).find("span").before(new_img);
      }
    });
  }
	check_status();

	$("#confirmModal").on("touchmove", function(event){
		event.preventDefault();
	});

  (function () {
      var file_id = $(".file-id").text();
      var option = {
          "auto_play": "1",
          "file_id": "9031868222953457775",    // file_id替换
          "app_id": "1253793695",
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
      player = new qcVideo.Player("id_video_container", option, listener);
  })();

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

});
