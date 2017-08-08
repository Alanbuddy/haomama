$ ->
  $(".input-box").focus ->
    $(".search-auto").show()

  search = ->
    page = 0
    value = $(".input-box").val()
    location.href = window.course_search + "?key=" + value

  $(".input-box").keydown (event) ->
    $(".search-auto").hide()
    code = event.which
    if code == 13
      search()

  $(".search-icon").click ->
    search()

  $('.tag-word').click ->
    $(this).closest('.search-auto').hide()
    word = $(this).text()
    $('.input-box').val(word)

  $('.back').click ->
    # back to front page
    location.href = window.home



