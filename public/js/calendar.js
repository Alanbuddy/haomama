$(document).ready(function(){
  var E = window.wangEditor;
  var editor = new E('#edit-area');
  editor.customConfig.uploadImgParams = {
      _token: window.token
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
  editor.create();

  // E = window.wangEditor;
  var editor_lesson = new E('#edit-title');

  editor_lesson.customConfig.uploadImgServer = window.fileupload;
  editor_lesson.customConfig.showLinkImg = false;
  editor_lesson.customConfig.menus = [
        'head'
     ];
  editor_lesson.customConfig.uploadHeaders = {
    'Accept' : 'HTML'
  };
  editor_lesson.create();

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
    height: 350,
    eventClick: function(calEvent, jsEvent, view){
      $("#calendar").fullCalendar('removeEvents', calEvent.id);
    }
    });

  var type = "tag";
  $('#type-tag').tagEditor({
    
    beforeTagSave: function(field, editor, tags, tag, val){
      $(".create-tag-div").find(".tag_id").each(function(){
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
      var delete_id = null;
      var del = "DELETE";
      $(".create-tag-div").find(".tag_id").each(function(){
        _this = $(this);
        if($(this).text() == val ){
          delete_id = $(this).attr("data-id");
          $.ajax({
            url: window.tag_destroy.substring(0, window.tag_destroy.length - 2) + delete_id,
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

  $(".hot-tag-div span").each(function(){
    $(this).click(function(){
      $('#type-tag').tagEditor('addTag', $(this).text());
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
                  value: item.name,
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

  function check_input(name, length, ori_price, price, mix_num, max_num){
    if(name == ""){
      showMsg("课程名称必须填写", "center");
      return false;
    }
    if(!$.isNumeric(length) || !$.isNumeric(ori_price) || !$.isNumeric(price) || !$.isNumeric(min_num) || !$.isNumeric(max_num)){
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

  function guid(){
    function s4(){
      Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
    }
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
  }

  function add_event(){
    var date = $("#datepicker").val().match(/[0-9]{4}-[0-9]{2}-[0-9]{2}/);
    if(date == null){
      $.page_notification("请输入合法的日期", 3000);
      return false;
    }
    date = date[0];

    var start_time = $("#start-time").val().match(/[0-9]{2}:[0-9]{2}:[0-9]{2}/);
    var end_time = $("#end-time").val().match(/[0-9]{2}:[0-9]{2}:[0-9]{2}/);
    if(start_time == null || end_time == null){
      $.page_notification("请输入合法的时间", 3000);
      return false;
    }
    start_time = start_time[0];
    end_time = end_time[0];

    var start_ary = start_time.split(":");
    var end_ary = end_time.split(":");
    var start_seconds = parseInt(start_ary[0]) * 3600 + parseInt(start_ary[1]) * 60 +parseInt(start_ary[2]);
    var  end_seconds = parseInt(end_ary[0]) * 3600 + parseInt(end_ary[1]) * 60 +parseInt(end_ary[2]);
    if(start_seconds >= end_seconds){
      $.page_notification("结束时间必须在开始时间之后", 3000);
      return false;
    }
    var e = {
      id: guid(),
      title: "",
      allDay: false,
      start: date + "T" + start_time,
      end: date + "T" + end_time,
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



  $("#finish-btn").click(function(){
    var name = $("#course-name").val().trim();
    var category_id = $("#course-type").val();
    var length = $("#course-length").val().trim();
    var original_price = $("#course-price").val().trim();
    var price = $("#pay-price").val().trim();
    var time = $("#lesson-date").val().trim();
    var min_num = $("#min-num").val().trim();
    var max_num = $("#max-num").val().trim();
    var address = $("#lesson-address").val().trim();

    var tags = [];
    $(".create-tag-div").find(".tag_id").each(function(){
      tags.push($(this).attr("data-id"));
    });
    var desc = editor.txt.html();
    // var lesson_title = editor_lesson.txt.html();   //课时标题添加
    var teacher_arr = [];
    $(".teacher-id").each(function(){
      teacher_arr.push($(this).text());
    });
    var path = $(".cover-path").text();
    var offline = "offline";
    var ret = check_input(name, length, original_price, price, min_num, max_num);
    if(ret == false) {
      return false;
    }
  });



});