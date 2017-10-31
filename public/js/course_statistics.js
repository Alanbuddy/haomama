$(document).ready(function(){

	$( "#datepicker-1" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange : '-20:+10'
  });
	$( "#datepicker-1" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
	$( "#datepicker-1" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$( "#datepicker-2" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange : '-20:+10'
  });
	$( "#datepicker-2" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
	$( "#datepicker-2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	
	$(".search-btn-statistics").click(function(){
		var left = $("#datepicker-1").val();
		var right = $("#datepicker-2").val();
		location.href = window.course_statistics + "?left=" + left + "&right=" + right;
	});
});