$(document).ready(function($) {
	$("#review-btn").click(function(){
	    $("#reviewModal").modal("show");
	  });
	$('#reviewModal').on('touchmove', function(event) {
	    event.preventDefault();
	});
	$("#test-btn").click(function(){
	    $("#profileModal").modal("show");
	  });
	$('.profile-close').click(function(){
	    $("#profileModal").modal("hide");
	    $('.add-baby-div').hide();
	});
	$("#code").click(function(){
	  var mobile = $("#mobile").val();
	  var mobile_retval = $.regex.isMobile(mobile);
	  if (mobile_retval === false) {
	    showMsg("手机号不正确", 'center');
	    return false;
	  }
	  time("#code");
	});
});