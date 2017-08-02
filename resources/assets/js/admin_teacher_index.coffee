$ ->
  $("#new-client").click ->
    location.href = window.teacher_new + "?type=teacher"


  search = ->
    value = $("#search-input").val()
    location.href = window.teacher_index + "?key=" + value

  $("#search-btn").click ->
    search()


  $("#search-input").keydown (event) ->
    code = event.which
    if code == 13
      search()

