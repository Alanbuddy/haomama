$ ->
  $(".input-box").keydown ->
    $(".search-auto").toggle()


  search = ->
    value = $(".input-box").val()
    location.href = "/courses"

  $(".input-box").keydown (event) ->
    code = event.which
    if code == 13
      search()

  $(".search-icon").click ->
    search()
