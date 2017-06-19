$ ->
  $(document).scroll ->
    if $(document).scrollTop() > 200
      $('.upper').fadeIn(1000)
    else
      $('.upper').fadeOut(1000)

  $('.upper').click ->
    $('body').animate({scrollTop: 0})

  $('.back').click ->
    location.href = window.home

  $('.course-item').click ->
    cid = $(this).attr('data-id')
    location.href = window.course_item + "/" +cid

  $('.category-class').each ->
    if $(this).text() == "分类N"
      $(this).addClass('health-title')
    else if $(this).text() == "分类t"
      $(this).addClass('psychology-title')
    else
      $(this).addClass('grow-title')

  # 上拉刷新没完成