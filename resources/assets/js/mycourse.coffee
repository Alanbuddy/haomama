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