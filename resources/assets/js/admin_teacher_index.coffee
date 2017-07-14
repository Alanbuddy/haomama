$ ->
  $("#new-client").click ->
    location.href = window.teacher_new + "?type=teacher"

  $(".teacher-show").click ->
    location.href = "/users/2" + "?type=teacher"
