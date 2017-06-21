

$(document).ready(function($){
  function check_status(){
    var enroll = $(".num-div").attr("data-enroll");
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

});
