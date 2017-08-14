$(document).ready(function(){
  var total = 0;
  var pageIndex = 0;     //页面索引初始值   
  var pageSize = 10;     //每页显示条数初始化，修改显示条数，修改这里即可
  $(".addlesson").click(function(){
    InitTable(0); 
    function PageCallback(index, jq) {  
      InitTable(index);  
      return false;
    }  
    function InitTable(pageIndex) {                                  
      $.ajax({   
          type: "get",  
          url: window.lessons_index,      //提交到一般处理程序请求数据   
          data: "page=" + (pageIndex + 1),          //提交两个参数：pageIndex(页面索引)，pageSize(显示条数)                   
          success: function(data) {
            total = data.total;
            $(".checkbox-items .checkbox").remove();
            for(var i=0;i<data.data.length;i++){
              var check_item = $('<div class="checkbox">' +
                                    '<label>' +
                                      '<input type="checkbox" name="lesson-check" value=' + data.data[i].id + ' data-text=' + data.data[i].name + '>' + data.data[i].name +
                                    '</label>' +
                                '</div>');
              $(".checkbox-items").append(check_item);
            }
            $("#Pagination").pagination(total, {
              callback: PageCallback,  //PageCallback() 为翻页调用次函数。
              prev_text: "«上一页",
              next_text: "»下一页",
              items_per_page: pageSize,
              num_edge_entries: 2,       //两侧首尾分页条目数
              num_display_entries: 4,    //连续分页主体部分分页条目数
              current_page: pageIndex,   //当前页索引
              link_to: "",
            });
          } 
      });
    }
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

  $(document).on('click', '#confirm-btn', function(){
    var title_arr = [];
    var title_text = [];
    $("[name='lesson-check']:input:checked").each(function(){
        var value = $(this).val();
        var text = $(this).attr("data-text");
        title_arr.push(value);
        title_text.push(text);
    });
    var len = title_arr.length;

    for(var i=0;i<len;i++){
      var oLi = $("<li data-id="+title_arr[i]+">" + "<span class='sort-span'>" + title_text[i] + "<img class='sort-delete' src='icon/admin/delete.png'>" + "</span>" + "</li>");
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

  $(document).on('mouseover', '.sort-span', function(){
    $(this).addClass("add-li-hover").find(".sort-delete").show();
  });

  $(document).on('mouseout', '.sort-span', function(){
    $(this).removeClass("add-li-hover").find(".sort-delete").hide();
  });

  $(document).on('click', '.sort-delete', function(){
    $(this).closest("li").remove();
  });

  $("#shelve-btn").click(function(){
    $("#shelfModal").modal("show");
  });

  $("#shelf-cancel").click(function(){
    $("#shelfModal").modal("hide");
  });
  
  function check_input(name, length, ori_price){
    if(name == ""){
      showMsg("课程名称必须填写", "center");
      return false;
    }
    if(!$.isNumeric(length) || !$.isNumeric(ori_price)){
      showMsg("请输入正确的数字", "center");
      return false;
    }
  }

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
      lesson_list.push($(this).attr("data-id"));
    });
    var lesson_title = [];
    $(".w-e-text p").each(function(){
      lesson_title.push($(this).text());
    });
    lesson_title.shift(lesson_title[0]);
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
    var online = "online";
    if (!$.isNumeric(price)){
      price = null;
    }
    if(!$.isNumeric(category_id)){
      showMsg("课程类型没有选择", "center");
      return false;
    }
    var ret = check_input(name, length, original_price);
    if(ret == false) {
      return false;
    }
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
        type: online,
        titles: lesson_title,
        _token: window.token
      },
      function(data){
        console.log(data);
        if(data.success){
          var cid = data.data.id;
          var str = window.admin_course_show.replace(/-1/, cid);
          location.href = str;
        }
      }
      );
  });
});

