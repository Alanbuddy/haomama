$(document).ready(function(){
  $(".addlesson").click(function(){
    $("#lessonModal").modal("show");
  });

  $('#type-tag').tagEditor();

  $( "#teacher" ).autocomplete({
      source: function(request, response){
        $.ajax({
          url: window.add_teacher,
          type: 'get',
          data: {
            name: request.term
          },
          success: function( data ) {  
            response( $.map( data.data, function( item ) {  
                return {
                    value: item.name
                };  
            }));  
          }  
        });
      
      },
      // minLength: 2,    //搜索字符的长度
      select: function( event, ui ) {
              $( "#teacher" ).val("");
              $(".unadd").hide();
              var teacher_tag = $("<span class='add-tag'><span class='teacher-name'></span><img class='delete-tag' src='/icon/admin/delete.png'></span>");
              teacher_tag.find(".teacher-name").text( ui.item.label);
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
    var teacher_input = $(this).val();
    if(code == 13 && teacher_input != ""){
      $( "#teacher" ).val("");
      $(".unadd").hide();
      var teacher_tag = $("<span class='add-tag'><span class='teacher-name'></span><img class='delete-tag' src='/icon/admin/delete.png'></span>");
      teacher_tag.find(".teacher-name").text(teacher_input);
      $(".teacher-tag").append(teacher_tag);
    }
  });

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
    var desc = editor.txt.html();
    var lesson_list = [];
    $(".example li").each(function(){
      lesson_list.push($(this).text());
    });
    var lesson_title = editor_lesson.txt.html();
    var teacher_arr = [];
    $(".teacher-name").each(function(){
      teacher_arr.push($(this).text());
    });

    //通过formData对象append方法来添加图片
    var formData = new formData();
    formData.append('file', $("#previewImg")[0].files[0]);
    $.ajax({
      url: window,
      type: 'post',
      data: formData,
      cache: false,
      processData: false,
      contentType: false
      }).done(function(res){

      }).fail(function(res){

      });

  });
});

