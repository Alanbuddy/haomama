$ ->
  $(document).scroll ->
    if $(document).scrollTop() > 200
      $('.upper').fadeIn(1000)
    else
      $('.upper').fadeOut(1000)

  $('.upper').click ->
    $('body').animate({scrollTop: 0})

  $('.back').click ->
    location.href = '/'

  $('.course-item').click ->
    location.href = '/'

  # 上拉刷新没完成