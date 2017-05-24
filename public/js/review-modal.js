$(document).ready(function($) {
	$("#review-btn").click(function(){
	    $("#reviewModal").modal("show");
	  });
	$('#reviewModal').on('touchmove', function(event) {
	    event.preventDefault();
	});
});