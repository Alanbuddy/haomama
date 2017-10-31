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

  $(document).on 'click', '.course-item', ->
    cid = $(this).attr('data-id')
    location.href = window.course_item + "/" +cid

