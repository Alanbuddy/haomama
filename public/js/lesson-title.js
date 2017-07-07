$(document).ready(function(){
  $(".addlesson").click(function(){
    $("#lessonModal").modal("show");
  });

  $('#type-tag').tagEditor();
  $("#teacher-tag").tagEditor({

      // autocomplete: {

      //     delay: 0, // show suggestions immediately

      //     position: { collision: 'flip' }, // automatic menu position up/down

      //     source: ['ActionScript', 'AppleScript', 'Asp', ... 'Python', 'Ruby']

      // },

      // forceLowercase: false,

      // placeholder: 'Programming languages ...'

  });
   // $("#finish-btn").click(function(){
   //   alert( $('#type-tag').tagEditor('getTags')[0].tags );
   //  })
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

  // $("#confirm-btn").click(function(){
  //   var title_arr = [];
  //   $("input:[name='lesson-check']").each(function(){
  //       var value = $(this).val();
  //       alert(value);
  //       title_arr.push(value);
  //   });
  // });
});
