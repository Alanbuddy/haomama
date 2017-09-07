$(document).ready(function(){
  $("#course-show").click(function(){
    location.href = window.course_show;
  });

  $("#register").click(function(){
    location.href = window.offline_student;
  });

  $(".select-style").change(function(){
    var num = $(this).val();
    
  });

});