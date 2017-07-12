$(document).ready(function(){

  $("#new-template").click(function(){
    $("#add_lessonModal").modal("show");
  });

  $(".close").click(function(){
    $("#add_lessonModal").modal("hide");
  });
    
});