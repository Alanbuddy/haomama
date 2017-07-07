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
     
   
});
