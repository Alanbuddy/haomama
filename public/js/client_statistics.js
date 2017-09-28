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
			type: 'datetime',
			tickInterval: 24 * 3600 * 1000,
      labels: {
      	format: '{value: %Y-%m-%d}'
      }
		},
		yAxis: {
		  title: {text: ''},
		  // max: 10
		},
		credits: {
		  enabled: false
		},
		legend: {
		  enabled: false
		},
		tooltip: {
      valueSuffix: '人',
      pointFormat: '{series.name}: <b>{point.y}</b>',
      dateTimeLabelFormats: {
        day: '%Y-%m-%d'
      }
	  },
		series: [
		  {
		  	name: '数量',
		    data: [1, 5, 7, 9, 33, 54, 56,34],
		    pointStart: Date.UTC(2017, 3, 1),  //查询时间
		    pointInterval: 24 * 3600 * 1000
		  }
		]
	});

	$("#active-statistics").highcharts({
		title: {
		  text: null
		},
		xAxis: {
			type: 'datetime',
			tickInterval: 24 * 3600 * 1000,
      labels: {
      	format: '{value: %Y-%m-%d}'
      }
		},
		yAxis: {
		  title: {text: ''},
		  // max: 10
		},
		credits: {
		  enabled: false
		},
		legend: {
		  enabled: false
		},
		tooltip: {
      valueSuffix: '人',
      pointFormat: '{series.name}: <b>{point.y}</b>',
      dateTimeLabelFormats: {
        day: '%Y-%m-%d'
      }
	  },
		series: [
		  {
		  	name: '数量',
		    data: [1, 5, 7, 9, 33, 54, 56,34],
		    pointStart: Date.UTC(2017, 3, 1),  //查询时间
		    pointInterval: 24 * 3600 * 1000
		  }
		]
	});

	$("#focus-statistics").highcharts({
		title: {
		  text: null
		},
		xAxis: {
			type: 'datetime',
			tickInterval: 24 * 3600 * 1000,
      labels: {
      	format: '{value: %Y-%m-%d}'
      }
		},
		yAxis: {
		  title: {text: ''},
		  // max: 10
		},
		credits: {
		  enabled: false
		},
		legend: {
		  enabled: false
		},
		tooltip: {
      valueSuffix: '人',
      pointFormat: '{series.name}: <b>{point.y}</b>',
      dateTimeLabelFormats: {
        day: '%Y-%m-%d'
      }
	  },
		series: [
		  {
		  	name: '数量',
		    data: [1, 5, 7, 9, 33, 54, 56,34],
		    pointStart: Date.UTC(2017, 3, 1),  //查询时间
		    pointInterval: 24 * 3600 * 1000
		  }
		]
	});

	$("#all-statistics").highcharts({
		title: {
		  text: null
		},
		xAxis: {
			type: 'datetime',
			tickInterval: 24 * 3600 * 1000,
      labels: {
      	format: '{value: %Y-%m-%d}'
      }
		},
		yAxis: {
		  title: {text: ''},
		  // max: 10
		},
		credits: {
		  enabled: false
		},
		legend: {
		  enabled: false
		},
		tooltip: {
      valueSuffix: '人',
      pointFormat: '{series.name}: <b>{point.y}</b>',
      dateTimeLabelFormats: {
        day: '%Y-%m-%d'
      }
	  },
		series: [
		  {
		  	name: '数量',
		    data: [1, 5, 7, 9, 33, 54, 56,34],
		    pointStart: Date.UTC(2017, 3, 1),  //查询时间
		    pointInterval: 24 * 3600 * 1000
		  }
		]
	});


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
		var current_url = location.href;
		location.href = current_url + "?left=" + left + "&right=" + right;
	});

});