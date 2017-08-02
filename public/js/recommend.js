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

});