

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
  }
	check_status();

	$("#confirmModal").on("touchmove", function(event){
		event.preventDefault();
	});

  (function () {
      var option = {
          "auto_play": "1",
          "file_id": "9031868222953457775",
          "app_id": "1253793695",
          "width": 750,
          "height": 422,
          "https": 1
      };
      /*调用播放器进行播放*/
      player = new qcVideo.Player("id_video_container", option);

      var barrage = [
          {"type": "content", "content": "hello world", "time": "1"},
          {"type": "content", "content": "居中显示", "time": "1", "style": "C64B03;30", "position": "center"}
      ];

      window.setTimeout(function () {
          player.addBarrage(barrage);
          console.log(2);
      }, 1000);

  })();

  $("#id_video_container").hover(function(){
    $(".back").show();
  },function(){
    $(".back").hide();
  });

});
