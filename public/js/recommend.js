$(document).ready(function(){
  $("#edit-btn").click(function(){
    $(this).toggle();
    $("#finish-btn").toggle();
    $(".unedit-box").toggle();
    $(".edit-box").toggle();
  });

  $("#course").click(function(){
    location.href = window.set_recommend;
  });

  $("#announce").click(function(){
    location.href = window.img_index;
  });

  $(".category").each(function(){
    $(this).autocomplete({
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
                $(this).val(ui.item.label);
                $(this).closest('.edit-box').siblings('.c-id').text(ui.item.object_id);
              }
      });
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
    var cid = [];
    $('.c-id').each(function(){
      cid.push($(this).text());
    });
    var re = {
          "新课速递": cid[0],
          "健康养育": cid[1],
          "心理教育": cid[2],
          "自我成长": cid[3]
        };
    console.log(re);
    $.ajax({
      type: "post",
      url: window.course_recommend,
      data: {
        recommend: re,
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