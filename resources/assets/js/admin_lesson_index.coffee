$ ->
  $(".lesson-video").click ->
    location.href = window.lesson_create + "?type=video"

  $(".lesson-audio").click ->
    location.href = window.lesson_create + "?type=audio"

  $("#video").click (e) ->
  	e.preventDefault()
  	location.href = window.lesson_index + "?type=video"

  $("#audio").click (e) ->
  	e.preventDefault()
  	location.href = window.lesson_index + "?type=audio"

  search = ->
    value = $("#search-input").val()
    location.href = window.lesson_search + "?key=value"

  $("#search-btn").click ->
    search()


  $("#search-input").keydown (event) ->
    code = event.which
    if code == 13
      search()

