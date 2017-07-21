$(document).ready(function(){

  $("#new-template").click(function(){
    $("#addModal").modal("show");
  });

  $(".close").click(function(){
    $("#addModal").modal("hide");
  });

  $(".course-type").each(function(){
  	if($(this).text() == "online"){
  		$(this).text("线上视频");
  	}
    if($(this).text() == "offline"){
      $(this).text("线下课程");
    }
  });
    
});