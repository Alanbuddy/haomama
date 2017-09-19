$(document).ready(function(){
	$(".title-div span").click(function(){
		$(".title-div span").removeClass('active');
		$(this).addClass('active');
		$(".figure-div").css("display", "none");
		$(".figure-div").eq($(this).index()).css("display", "block");
		$(".figure-div").eq($(this).index()).find("div").highcharts().reflow();
	});

	$("#new-statistics").highcharts({
		title: {
		  text: null
		},
		xAxis: { 
		  title: {
		    text: '周数'
		  }
		},
		yAxis: {
		  title: {text: '儿童数量'},
		  // max: 10
		},
		credits: {
		  enabled: false
		},
		legend: {
		  enabled: false
		},
		series: [
		  {
		    data: [1, 5, 7, 9, 33, 54, 56,34],
		    pointStart: 1
		  }
		]
	});

	$("#active-statistics").highcharts({
		title: {
		  text: null
		},
		xAxis: { 
		  title: {
		    text: '周数'
		  }
		},
		yAxis: {
		  title: {text: '儿童数量'},
		  // max: 10
		},
		credits: {
		  enabled: false
		},
		legend: {
		  enabled: false
		},
		series: [
		  {
		    data: [1, 5, 7, 9, 33, 54, 56,34],
		    pointStart: 1
		  }
		]
	});

	$("#focus-statistics").highcharts({
		title: {
		  text: null
		},
		xAxis: { 
		  title: {
		    text: '周数'
		  }
		},
		yAxis: {
		  title: {text: '儿童数量'},
		  // max: 10
		},
		credits: {
		  enabled: false
		},
		legend: {
		  enabled: false
		},
		series: [
		  {
		    data: [1, 5, 7, 9, 33, 54, 56,34],
		    pointStart: 1
		  }
		]
	});

	$("#all-statistics").highcharts({
		title: {
		  text: null
		},
		xAxis: { 
		  title: {
		    text: '周数'
		  }
		},
		yAxis: {
		  title: {text: '儿童数量'},
		  // max: 10
		},
		credits: {
		  enabled: false
		},
		legend: {
		  enabled: false
		},
		series: [
		  {
		    data: [1, 25, 7, 9, 33, 54, 56,34],
		    pointStart: 1
		  }
		]
	});


});