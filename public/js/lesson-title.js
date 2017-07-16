$(document).ready(function(){
  $(".addlesson").click(function(){
    $("#lessonModal").modal("show");
  });

  $('#type-tag').tagEditor();
  $("#teacher-tag").tagEditor({
    beforeTagSave: function(){
      alert("123");
    }
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
  
  var E = window.wangEditor;
  var editor = new E('#edit-area');
  editor.customConfig.uploadImgServer = '/upload' ;
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
  var editor_lesson = new E('#title-area');

  editor_lesson.customConfig.uploadImgServer = '/upload' ;
  editor_lesson.customConfig.showLinkImg = false;
  editor_lesson.customConfig.menus = [
        'head'
     ];
  editor_lesson.customConfig.uploadHeaders = {
    'Accept' : 'HTML'
  };
  editor_lesson.create();

  $("#confirm-btn").click(function(){
    var title_arr = [];
    $("[name='lesson-check']:input:checked").each(function(){
        var value = $(this).val();
        title_arr.push(value);
    });
    var len = title_arr.length;

    for(var i=0;i<len;i++){
      var oLi = $("<li>" + title_arr[i] + "</li>");
      $(".example").append(oLi);
    }

    $("[name='lesson-check']:input:checked").each(function(){
      this.checked = false;
    });
    $("#lessonModal").modal("hide");
  });

  $(".close").click(function(){
    $("[name='lesson-check']:input:checked").each(function(){
      this.checked = false;
    });
    $("#lessonModal").modal("hide");
  });

  $("#all-no").click(function(){
    $("[name='lesson-check']:input").each(function(){
      this.checked = !this.checked;
    });
  });

  $("ol.example").sortable();

  $("#shelve-btn").click(function(){
    $("#shelfModal").modal("show");
  });

  $("#shelf-cancel").click(function(){
    $("#shelfModal").modal("hide");
  });
  
  $(".hot-tag-div span").each(function(){
    $(this).click(function(){
      $('#type-tag').tagEditor('addTag', $(this).text());
    });
  });

  $(document).on('click',"#finish-btn", function(){
    var name = $("#course-name").val().trim();
    var type = $("#course-type").val();
    var length = $("#course-length").val().trim();
    var price = $("#course-price").val().trim();
    var pay_price = $("#pay-price").val().trim();
    var tags = $('#type-tag').tagEditor('getTags')[0].tags;
    var teacher = $('#teacher-tag').tagEditor('getTags')[0].tags;
    var desc = editor.txt.html();
    var lesson_list = [];
    $(".example li").each(function(){
      lesson_list.push($(this).text());
    });
    var lesson_title = editor_lesson.txt.html();

    console.log(teacher);

  });
});

