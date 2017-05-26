

$(document).ready(function($){
	$("a.unopen").click(function(){
		$("#confirmModal").modal("show");
	});
	$("#confirmModal").on("touchmove", function(event){
		event.preventDefault();
	});
});
