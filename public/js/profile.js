$(document).ready(function($) {
	var timer = null;
	var wait = 60;
	var time = function(o) {
		$(o).attr("disabled", true);
		if (wait == 0) {
			$(o).attr("disabled", false);
			$(o).text('发送验证码');
			return wait = 60;
		} else {
			$(o).text('重发(' + wait + ')');
			wait--;
			timer = setTimeout(function(){
				time(o);
			}, 1000);
		}
	};
	$(".replace").click(function(){
	    $("#mobileModal").modal("show");
	  });
	
});