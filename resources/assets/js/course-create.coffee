$ ->
  $(".input-box").focus ->
    $(".search-auto").show()

  search = ->
    value = $(".input-box").val()
    location.href = "/courses"

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

