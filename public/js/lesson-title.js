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
     
  

  $("#confirm-btn").click(function(){
    var title_arr = [];
    $("[name='lesson-check']:input:checked").each(function(){
        var value = $(this).val();
        title_arr.push(value);
    });
    var len = title_arr.length;
    for(var i=0;i<len;i++){
      var oLi = $("<li>" + title_arr[i] + "</li>");
      $(".lesson-title").append(oLi);
    }
    $("[name='lesson-check']:input").attr("checked", false);
    $("#lessonModal").modal("hide");
  });

  $(".close").click(function(){
    $("[name='lesson-check']:input").attr("checked", false);
    $("#lessonModal").modal("hide");
  });
});
