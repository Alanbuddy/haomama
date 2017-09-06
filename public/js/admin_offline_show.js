$(document).ready(function(){
	var is_edit = false;
	$("#edit-btn").click(function(){
		is_edit = true;
		$(this).toggle();
		$(".unedit-box").toggle();
		$(".edit-box").toggle();
		$("#finish-btn").toggle();
		$(".calendar-operation-wrapper").toggle();
		$("#name-control").removeClass('mt30');
		$("#edit-tag").addClass('mb8');
		$(".calendar-operation-wrapper").show();
		$(".calendar-wrapper").css("border", "1px solid #c8c8c8");
		$("#calendar").removeClass("show-calendar").addClass("edit-calendar");
    $(".operation").attr("disabled", true);

		$("#lesson-date").val($("#date-span").text());
		$("#min-num").val($("#min-span").text());
		$("#max-num").val($("#max-span").text());
		$("#lesson-address").val($("#address-span").text());

		$("#course-name").val($("#name-span").text());
		var category_id = $("#type-span").attr("data-type-id");
		$("#course-type").val(category_id);
		$("#course-length").val($("#length-span").text());
		$("#course-price").val($("#original-span").text());
		$("#pay-price").val($("#price-span").text());

		var teacher_arr = [];
		$(".teacher-tag-span").each(function(){
		  teacher_arr.push($(this).text());
		});
		$("#teacher-show").text(teacher_arr);
		var desc = $("#desc-html").text();
		editor.txt.html(desc);

		var E = window.wangEditor;
		editor_lesson = new E('#unedit-title');
		$("#unedit-title").addClass('wangedit-area').toggle();
		editor_lesson.customConfig.uploadImgServer = window.fileupload;
		editor_lesson.customConfig.showLinkImg = false;
		editor_lesson.customConfig.menus = [
		      'head'
		   ];
		editor_lesson.customConfig.uploadHeaders = {
		  'Accept' : 'HTML'
		};
		editor_lesson.create();

	});

	var E = window.wangEditor;
	var editor = new E('#edit-area');
	editor.customConfig.uploadImgParams = {
	    _token: window.token,
	    editor: "1"
	};
	editor.customConfig.uploadFileName = 'file';
	editor.customConfig.uploadImgServer = window.fileupload;
	editor.customConfig.showLinkImg = false;
	editor.customConfig.menus = [
	      'head',
	      'image'
	   ];
	editor.customConfig.uploadHeaders = {
	  'Accept' : 'HTML'
	};
    editor.customConfig.uploadImgTimeout = 3600000;
	editor.create();


	var tag_arr = [];
	$(".tag-span").each(function(){
	  tag_arr.push($(this).text());
	});
	var type = "tag";
	$('#type-tag').tagEditor({
	  initialTags: tag_arr,
	  beforeTagSave: function(field, editor, tags, tag, val){
	    $(".create-tag-div").find(".tag_id").each(function(){
	      if($(this).text() == val ){
	        showMsg("标签不可重复","center");
	        return false;
	      }
	    });
      $(".hot-tag-div").find("span").each(function(){
        if($(this).text() == val ){
          showMsg("标签不可重复","center");
          return false;
        }
      });
	    $.postJSON(
	      window.tag_store,
	      {
	        name: val,
	        type: type,
	        _token: window.token
	      },
	      function(data){
	        var tag_id = $("<div class='tag_id'></div>");
	        tag_id.text(val);
	        tag_id.attr("data-id", data.data.id);
	        $(".create-tag-div").append(tag_id);
	      }
	      );
	  },
	  beforeTagDelete: function(field, editor, tags, val){
      $(".tag-span").each(function(){
        if($(this).text() == val){
          $(this).remove();
        }
      });
	    var delete_id = null;
	    var del = "DELETE";
	    $(".create-tag-div").find(".tag_id").each(function(){
	      _this = $(this);
	      if($(this).text() == val ){
	        delete_id = $(this).attr("data-id");
	        $.ajax({
	          url: window.tag_destroy.replace(/-1/, delete_id),
	          type: 'post',
	          data: {
	            id: delete_id,
	            _method: del,
	            _token: window.token
	          },
	          success: function(){
	            _this.remove();
	          }
	        });
	      }
	    });
	  }
	});

	var tag_name = [];
  $("tag-editor-tag").each(function(){
    tag_name.push($(this).text());
  });
  $(".hot-tag-div span").each(function(){
    $(this).click(function(){
      if(tag_name.indexOf($(this).text()) == -1){
        $('#type-tag').tagEditor('addTag', $(this).text());
      }else{
        showMsg("该标签已存在", "center");
        return false;
      }
    });
  });

	$( "#teacher" ).autocomplete({
	    source: function(request, response){
	      $.ajax({
	        url: window.add_teacher,
	        type: 'get',
	        data: {
	          name: request.term
	        },
	        success: function( data ) {
	          // console.log(data.data);  
	          response( $.map( data.data, function( item ) {  
	              return {
	                  value: item.name+ (item.remark? '('+item.remark+')':''),
	                  object_id: item.id
	              };  
	          }));  
	        }  
	      });
	    
	    },
	    // minLength: 2,    //搜索字符的长度
	    select: function( event, ui ) {
	            $( "#teacher" ).val("");
	            $(".unadd").hide();
	            var teacher_tag = $("<span class='add-tag'><span class='teacher-name'></span><span class='teacher-id'></span><img class='delete-tag' src='icon/admin/delete.png'></span>");
	            teacher_tag.find(".teacher-name").text( ui.item.label);
	            teacher_tag.find(".teacher-id").text( ui.item.object_id);
	            $(".teacher-tag").append(teacher_tag);
	            return false;
	          }
	  });

	$(document).on('mouseover', '.add-tag', function(){
	  $(this).addClass("add-tag-hover").find(".delete-tag").show();
	});

	$(document).on('mouseout', '.add-tag', function(){
	  $(this).removeClass("add-tag-hover").find(".delete-tag").hide();
	});

	$(document).on('click', '.delete-tag', function(){
	  $(this).closest(".add-tag").remove();
	  if($(".delete-tag").length === 0){
	    $(".unadd").show();
	  }
	});

	$("#teacher").keydown(function(ev){
	  var ev = ev || window.event;
	  var code = ev.which;
	  if(code == 13){
	    $(this).val("");
	    showMsg("老师只可以从列表中点击选择,如无需在讲师管理中添加", "center");
	    return false;
	  }
	});

	function guid(){
	  function s4(){
	    return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
	  }
	  return (s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4());
	}

	var initialLocaleCode = "zh-cn";
	$('#calendar').fullCalendar({
	  header: {
	          left: 'prev,next today',
	          center: 'title',
	          right: 'month,agendaWeek,agendaDay,listMonth'
	        },
	  locale: initialLocaleCode,
	  weekNumbers: true,
	  navLinks: true,
	  editable: true,
	  eventLimit: true,
	  fixedWeekCount: false,
	  nowIndicator: true,
	  height: 360,
	  eventClick: function(calEvent, jsEvent, view){
	  	if(is_edit == false){
	  		return false;
	  	}
	    $("#calendar").fullCalendar('removeEvents', calEvent.id);
	  }
	});

	var date_arr = [];
	$(".date-div span").each(function(){
		date_arr.push($(this).text());
	});
	function parse_calendar_events(){
	  $.each(
	    date_arr,
	    function(index, event_str){
	      if(event_str != ""){
	        var start_str = event_str.split(',')[0];
	        var end_str = event_str.split(',')[1];
	        var e = {
	          id: guid(),
	          title: "",
	          allDay: false,
	          start: start_str,
	          end: end_str
	        };
	        $("#calendar").fullCalendar('renderEvent', e, true);
	      }
	    });
	}
	parse_calendar_events();

	function check_input(name, length, ori_price, min_num, max_num){
	  if(name == ""){
	    showMsg("课程名称必须填写", "center");
	    return false;
	  }
	  if(!$.isNumeric(length) || !$.isNumeric(ori_price) || !$.isNumeric(min_num) || !$.isNumeric(max_num)){
	    showMsg("请输入正确的数字", "center");
	    return false;
	  }
	}

	$( "#datepicker" ).datepicker({
	      changeMonth: true,
	      changeYear: true,
	      yearRange : '-20:+10'
	    });
	$( "#datepicker" ).datepicker( $.datepicker.regional[ "zh-TW" ] );
	$( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );

	$('#start-time').timepicker({
	  'minTime': '7:00am',
	  'maxTime': '9:00pm',
	  'showDuration': false,
	  'timeFormat': 'H:i:s'
	});
	$('#end-time').timepicker({
	  'minTime': '7:00am',
	  'maxTime': '9:00pm',
	  'showDuration': false,
	  'timeFormat': 'H:i:s'
	});

	var can_repeat = false;
	function enable_repeat(){
	  can_repeat = true;
	  $(".date-btn").addClass("active-btn");
	  $(".week-btn").addClass("active-btn");
	}

	function disable_repeat(){
	  can_repeat = false;
	  $(".date-btn").removeClass("active-btn");
	  $(".week-btn").removeClass("active-btn");
	}

	function add_event(){
	  var date = $("#datepicker").val().match(/[0-9]{4}-[0-9]{2}-[0-9]{2}/);
	  if(date == null){
	    showMsg("请输入合法的日期", "center");
	    return false;
	  }
	  date = date[0];

	  var start_time = $("#start-time").val().match(/[0-9]{2}:[0-9]{2}:[0-9]{2}/);
	  var end_time = $("#end-time").val().match(/[0-9]{2}:[0-9]{2}:[0-9]{2}/);
	  if(start_time == null || end_time == null){
	    showMsg("请输入合法的时间", "center");
	    return false;
	  }
	  start_time = start_time[0];
	  end_time = end_time[0];

	  var start_ary = start_time.split(":");
	  var end_ary = end_time.split(":");
	  var start_seconds = parseInt(start_ary[0]) * 3600 + parseInt(start_ary[1]) * 60 +parseInt(start_ary[2]);
	  var  end_seconds = parseInt(end_ary[0]) * 3600 + parseInt(end_ary[1]) * 60 +parseInt(end_ary[2]);
	  if(start_seconds >= end_seconds){
	    showMsg("结束时间必须在开始时间之后", "center");
	    return false;
	  }
	  var e = {
	    id: guid(),
	    title: "",
	    allDay: false,
	    start: date + " " + start_time,
	    end: date + " " + end_time,
	  };
	  $("#calendar").fullCalendar('renderEvent', e, true);
	  $("#calendar").fullCalendar("gotoDate", Date.parse(date));
	  enable_repeat();
	}

	$("#add-event").click(function(){
	  add_event();
	});

	$("#datepicker").change(function(){
	  disable_repeat();
	});

	$("#start-time").change(function(){
	  disable_repeat();
	});

	$("#end-time").change(function(){
	  disable_repeat();
	});

	$(".week-btn").click(function(){
	  if(can_repeat == false){
	    return false;
	  }
	  date = $("#datepicker").val();
	  var next_week = new Date(Date.parse(date) + 7 * 86400000);
	  $("#datepicker").datepicker("setDate", next_week);
	  add_event();
	});
	  

	$(".date-btn").click(function(){
	  if(can_repeat == false){
	    return false;
	  }
	  date = $("#datepicker").val();
	  var next_day = new Date(Date.parse(date) + 86400000);
	  $("#datepicker").datepicker("setDate", next_day);
	  add_event();
	});

	$(".operation").click(function(){
	  $("#shelfModal").modal("show");
	});

	$("#shelf-cancel").click(function(){
	  $("#shelfModal").modal("hide");
	});

	$("#shelf-confirm").click(function(){
	  $.getJSON(
	    window.course_publish,
	    {},
	    function(data){
	      console.log(data);
	      if(data.success){
	        $("#shelfModal").modal("hide");
	        if(data.data == "publish"){
	          $(".operation").text("下架课程");
	          $("#shelfModal .message").text("是否确认下架当前课程？");
            location.href = window.course_show;
	        }else{
	          if(data.data == "draft")
	          $(".operation").text("上线课程");
	      		$("#shelfModal .message").text("是否确认上线当前课程？");
            location.href = window.course_show;
	        }
	      }
	    }
	    );
	});

	$(document).on('click',"#finish-btn", function(){
	  var name = $("#course-name").val().trim();
	  var category_id = $("#course-type").val();
	  var length = $("#course-length").val().trim();
	  var original_price = $("#course-price").val().trim();
	  var price = $("#pay-price").val().trim();
	  var time = $("#lesson-date").val().trim();
	  var min_num = $("#min-num").val().trim();
	  var max_num = $("#max-num").val().trim();
	  var address = $("#lesson-address").val().trim();
	  if(time == ""){
	    showMsg("上课时间没有填写", "center");
	    return false;
	  }
	  if(address == ""){
	    showMsg("上课地点没有填写", "center");
	    return false;
	  }
	  var tags = [];
	  $(".create-tag-div").find(".tag_id").each(function(){
	    tags.push($(this).attr("data-id"));
	  });
	  $(".tag-span").each(function(){
	    tags.push($(this).attr("data-id"));
	  });
	  if(tags.length == 0){
	    showMsg("课程标签没有填写", "center");
	    return false;
	  }
	  var desc = editor.txt.html();
	  var course_info = editor.txt.text();
	  if(course_info == ""){
	    showMsg("课程介绍没有填写", "center");
	    return false;
	  }
    var lesson_title = [];
    $(".w-e-text").last().find("p").each(function(){
        if($(this).text()!='')
      lesson_title.push($(this).text());
    });
    // lesson_title.shift(lesson_title[0]);
    console.log(lesson_title);
    if(lesson_title.length != parseInt(length)){
      showMsg("课程节数和课时标题数不匹配", "center");
      return false;
    }
	  var teacher_arr = [];
	  $(".teacher-id").each(function(){
	    teacher_arr.push($(this).text());
	  });
    if(teacher_arr.length == 0){
      showMsg("授课老师没有添加", "center");
      return false;
    }
	  var path = $(".cover-path").text();
	  var offline = "offline";
	  
	  var fc_events = $('#calendar').fullCalendar('clientEvents');
	  var date_in_calendar = [];

	  $.each(
	    fc_events,
	    function(index, fc_event){
	      date_in_calendar.push(fc_event.start._i + "," + fc_event.end._i);
	    }
	  );
    if (!$.isNumeric(price)){
      price = null;
    }
    if(!$.isNumeric(category_id)){
      showMsg("课程类型没有选择", "center");
      return false;
    }
	  var ret = check_input(name, length, original_price, min_num, max_num);
    if(ret == false) {
      return false;
    }
	  $.putJSON(
	    window.course_update,
	    {
	      name: name,
        category_id: category_id,
        lessonsCount: length,
        original_price: original_price,
        price: price,
        tags: tags,
        teachers: teacher_arr,
        description: desc,
        cover: path,
        type: offline,
        minimum: min_num,
        quota: max_num,
        address: address,
        time: time,
        schedule: date_in_calendar,
        titles: lesson_title,
	      _token: window.token
	    },
	    function(data){
	      if(data.success){
	      	is_edit = false;
	        location.href = window.course_show;
	      }
	    }
	    );
	});
  
  $("#delete-btn").click(function(){
    var del = "DELETE";
    $.ajax({
      type: "post",
      url: window.course_del,
      data: {
        _token: window.token,
        _method: del
      },
      success: function(data){
        if(data.success){
          location.href = window.course_index;
        }else{
          showMsg("该课程不可以删除", "center");
        }
      }
    });
  });

  $("#register").click(function(){
  	location.href = window.offline_student;
  });

  $("#sign").click(function(){
  	location.href = window.course_signin;
  });

});