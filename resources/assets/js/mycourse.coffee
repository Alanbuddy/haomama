$ ->
  $(".category-class").each ->
    if $(this).text() == "鍒嗙被N"
      $(this).addClass('health-title')
    else if $(this).text() == "鍒嗙被t"
      $(this).addClass('psychology-title')
    else
      $(this).addClass('grow-title')

  $(".back").click ->
    location.href = window.userid

  $('.course-item').click ->
    cid = $(this).attr('data-id')
    location.href = window.course + "/" +cid 