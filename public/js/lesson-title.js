$(document).ready(function(){
  $(".addlesson").click(function(){
    alert("aa");
    $.getJSON(
      window.lessons_index,
      {},
      function(data){
        console.log(data);
      }
      );
    $("#lessonModal").modal("show");
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
  var editor_lesson = new E('#title-area');

  editor_lesson.customConfig.uploadImgServer = window.fileupload;
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
    var title_text = [];
    $("[name='lesson-check']:input:checked").each(function(){
        var value = $(this).val();
        var text = $(this).text();
        title_arr.push(value);
        title_text.push(text);
    });
    var len = title_arr.length;

    for(var i=0;i<len;i++){
      var oLi = $("<li 'data-id'=title_arr[i]>" + title_text[i] + "</li>");
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
  

  $(document).on('click',"#finish-btn", function(){
    var name = $("#course-name").val().trim();
    var category_id = $("#course-type").val();
    var length = $("#course-length").val().trim();
    var original_price = $("#course-price").val().trim();
    var price = $("#pay-price").val().trim();
    var tags = [];
    $(".create-tag-div").find(".tag_id").each(function(){
      tags.push($(this).attr("data-id"));
    });
    var desc = editor.txt.html();
    var lesson_list = [];
    $(".example li").each(function(){
      lesson_list.push($(this).text());
    });
    var lesson_title = editor_lesson.txt.html();
    var teacher_arr = [];
    $(".teacher-id").each(function(){
      teacher_arr.push($(this).text());
    });
    var path = $(".cover-path").text();
    $.postJSON(
      window.course_store,
      {
        name: name,
        category_id: category_id,
        lessonsCount: length,
        original_price: original_price,
        price: price,
        tags: tags,
        teachers: teacher_arr,
        description: desc,
        lessons: lesson_list,
        cover: path,
        _token: window.token
      },
      function(data){
        console.log(data);
      }
      );
  });
});

