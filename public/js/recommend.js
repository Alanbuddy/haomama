$(document).ready(function(){
  $("#edit-btn").click(function(){
    $(this).toggle();
    $("#finish-btn").toggle();
    $(".unedit-box").toggle();
    $(".edit-box").toggle();
    $("#new").val($("#new-span").text());
    $("#health").val($("#health-span").text());
    $("#mental").val($("#mental-span").text());
    $("#grow").val($("#grow-span").text());
  });

  $("#course").click(function(){
    location.href = window.set_recommend;
  });

  $("#announce").click(function(){
    location.href = window.img_index;
  });

  $( "#new" ).autocomplete({
      source: function(request, response){
        $.ajax({
          url: window.course_search,
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
              $( "#teacher" ).val(ui.item.label);
              $(".new-id").text(ui.item.object_id);
            }
    });

  $( "#health" ).autocomplete({
      source: function(request, response){
        $.ajax({
          url: window.course_search,
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
              $( "#health" ).val(ui.item.label);
              $(".health-id").text(ui.item.object_id);
            }
    });

  $( "#mental" ).autocomplete({
      source: function(request, response){
        $.ajax({
          url: window.course_search,
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
              $( "#mental" ).val(ui.item.label);
              $(".mental-id").text(ui.item.object_id);
            }
    });

  $( "#grow" ).autocomplete({
      source: function(request, response){
        $.ajax({
          url: window.course_search,
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
              $( "#grow" ).val(ui.item.label);
              $(".grow-id").text(ui.item.object_id);
            }
    });
  
  $("#finish-btn").click(function(){
    var new_id = $(".new-id").text();
    var health_id = $(".health-id").text();
    var mental_id = $(".mental-id").text();
    var grow_id = $(".grow-id").text();
    $.ajax({
      type: "post",
      url: window.course_recommend,
      data: {
        recommend: {
          "新课速递": new_id,
          "健康养育": health_id,
          "心理教育": mental_id,
          "自我成长": grow_id
        },
        _token: window.token
      },
      success: function(data){
        if(data.success){
          location.href = window.set_recommend;
        }
      }
    });

  });

});