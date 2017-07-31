$(document).ready(function(){

  $("#course").click(function(){
    var teacher_id = $(".teacher-id").text();
    location.href = window.teacher_course.replace(/-1/, teacher_id);
  });

  $("#teacher-desc").click(function(){
    var teacher_id = $(".teacher-id").text();
    location.href = window.teacher_show.replace(/-1/, teacher_id);

  });
});