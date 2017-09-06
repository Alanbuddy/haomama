$(document).ready(function(){
  $("#course-show").click(function(){
    location.href = window.course_show;
  });

  $("#sign").click(function(){
    location.href = window.course_signin;
  });
  var node = "";
   
  $(".details").click(function(){
    var span = $(this).find("span");
    var row = $(this).closest("tr");
    var cid = row.attr("data-id");
    var status = row.next();
    status.toggle();
    if (span.hasClass("triangle-down")){
      span.removeClass("triangle-down").addClass("triangle-up");
    }
    else{
      span.removeClass("triangle-up").addClass("triangle-down");
    }
    if(status.find(".course-status span").length == 1){
      $.ajax({
        type: 'get',
        url: window.attendence.replace(/-1/, cid),
        success: function(data){
          for(var i=0;i<data.length;i++){
            node = render(data[i]);
            node.appendTo(status.find(".course-status"));
          }
        }
      });
    }
  });

  function render(item){
    var tem = $(`<span class="square"></span>`);
    if (item.hasAttended === true){
      tem.addClass("join-square");
    }
    else if (item.hasAttended === false){
      tem.addClass("miss-square");
    }
    return tem;
  }   
});