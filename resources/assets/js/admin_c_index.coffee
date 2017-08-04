
$ ->

  search = ->
    value = $("#search-input").val()
    location.href = window.course_search + "?key=" + value

  $("#search-btn").click ->
    search()


  $("#search-input").keydown (event) ->
    code = event.which
    if code == 13
      search()
    

  $(".course-video").click ->
    location.href = window.course_create

  $(".offline").click ->
    console.log(window.course_create)
    location.href = window.course_create + "?type=offline"

  $("#open").click ->
    location.href = window.course_index

  $("#unopen").click ->
    location.href = window.unopen

  $("#end").click ->
    location.href = window.end


