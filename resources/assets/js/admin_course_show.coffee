$ ->  

  $("#register-message").click ->
    $("#unshelve-btn").hide()
    $("#edit-btn").hide()
    $("#finish-btn").hide()
    $("#shelve-btn").hide()

  $("#course-comment").click ->
    $("#unshelve-btn").hide()
    $("#edit-btn").hide()
    $("#finish-btn").hide()
    $("#shelve-btn").hide()

  $("#course-desc").click ->
    location.href = window.course_show
  
  $("#register-message").click ->
    location.href = window.student

  $("#course-comment").click ->
    location.href = window.comment


