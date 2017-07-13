
$ ->

  if window.profile == "template"
    $('.nav-tabs a[href="#tab2"]').tab('show')
  # search-btn press
  text = $("#search-input").val()
  if text == ""
    $("#search-btn").addClass("search")
    $("#search-btn").removeClass("delete")
  else
    $("#search-btn").addClass("delete")
    $("#search-btn").removeClass("search")

  search = ->
    value = $("#search-input").val()
    location.href = "/staff/courses?keyword=" + value + "&page=1"

  $("#search-btn").click ->
    if $("#search-btn").hasClass("search")
      search()
      $("#search-btn").addClass("delete")
      $("#search-btn").removeClass("search")
    else
      back()
      $("#search-btn").addClass("search")
      $("#search-btn").removeClass("delete")


  $("#search-input").keydown (event) ->
    code = event.which
    if code == 13
      search()
      $("#search-btn").addClass("delete")
      $("#search-btn").removeClass("search")
    else
      $("#search-btn").addClass("search")
      $("#search-btn").removeClass("delete")

  $(".set-available").click ->
    current_state = "unavailable"
    if $(this).hasClass("font-color-red")
      current_state = "available"
    cid = $(this).closest("tr").attr("data-id")
    link = $(this)
    console.log current_state
    $.postJSON(
      '/staff/courses/' + cid + '/set_available',
      {
        available: current_state == "unavailable"
      },
      (data) ->
        console.log data
        if data.success
          $.page_notification("操作完成")
          if current_state == "available"
            link.removeClass("font-color-red")
            link.addClass("font-color-green")
            link.text("上架")
          else
            link.addClass("font-color-red")
            link.removeClass("font-color-green")
            link.text("下架")
        else
          if data.code == COURSE_PARTICIPATE_EXIST
            $.page_notification("该课程有人报名，不能下架")
      )
    return false

  $(".course-video").click ->
    location.href = window.course_create

  $(".offline").click ->
    console.log(window.course_create)
    location.href = window.course_create + "?type=offline"

  $(".show-name").click ->
    location.href = "/courses/1"



