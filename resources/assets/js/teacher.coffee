
$ ->
  $(".back").click ->
    location.href = history.back()

  $('.category-class').each ->
    if $(this).text() == "分类N"
      $(this).addClass('health-title')
    else if $(this).text() == "分类t"
      $(this).addClass('psychology-title')
    else
      $(this).addClass('grow-title')

  $(".course-item").click ->
    cid = $(this).attr("data-id")
    location.href = window.course_item + "/" +cid