$(document).ready(function(){
  $(".operation").click(function(){
    $("#shelfModal").modal("show");
  });

  $("#shelf-confirm").click(function(){
    $.getJSON(
      window.course_publish,
      {},
      function(data){
        console.log(data);
        if(data.success){
          $("#shelfModal").modal("hide");
          if(data.data == "publish"){
            $(".operation").text("下架课程");
          }else{
            if(data.data == "draft")
            $(".operation").text("上线课程");
          }
        }
      }
      );
  });



});