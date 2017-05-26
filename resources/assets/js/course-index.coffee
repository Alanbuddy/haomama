
$ ->

  $(".course-nav li").click ->
    $(".course-nav li").removeClass('course-active')
    $(this).addClass('course-active')
    $(".course-item-div").css('display', 'none');
    $(".course-item-div").eq($(this).index()).css('display', 'block')

  $("#home").click ->
    # jump to home_page
    location.href = ""

  $("#mine").click ->
    # jump to mine_page
    location.href = ""

  search = ->
    val = $(".search-input").val()
    # jump to search_page
    location.href = ""

  $(".search").click ->
    search()

  $(".search-input").keydown (event) ->
    code = event.which
    if code == 13
      search()

