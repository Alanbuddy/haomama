$ ->
  $("#view").click ->
    cid = $(".course-id").text()
    location.href = window.course_item + "/" + cid