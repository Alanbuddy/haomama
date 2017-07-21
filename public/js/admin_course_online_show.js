$(document).ready(function(){
  $(".operation").click(function(){
    var btn = $(this);
    $.postJSON(
      window.course_publish,
      {},
      function(data){
        console.log(data);
        if(data.success){
          if(data.data == "publish"){
            btn.text("下架课程");
          }else{
            if(data.data == "draft")
            btn.text("上线课程");
          }
        }
      }
      );
  });



});