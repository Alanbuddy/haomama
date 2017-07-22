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
    $("#unshelve-btn").show()
    $("#shelve-btn").show()
    if is_edit
      $("#finish-btn").show()
    else
      $("#edit-btn").show()

