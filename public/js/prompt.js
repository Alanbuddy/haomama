

$(document).ready(function($){
	$("a.unopen").click(function(){
		$("#confirmModal").modal("show");
	});
	$("#confirmModal").on("touchmove", function(event){
		event.preventDefault();
	});

	// var free_img = "<img class='free-icon' src= '/icon/free.png'>";
	// $(".num-div a:eq(0)").find("span").before(free_img);
});
