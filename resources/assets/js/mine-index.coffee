$ ->
  $(".avatar-div").click ->
  	# jump to profile_page
    location.href = window.profile

  $(".message-icon").click ->
  	# juml to messgae_page
  	location.href = ""

  $(".item-right").click ->
  	# jump to signin_page
  	location.href = ""

  $(".favorite-more").click ->
  	# jump to favorite page 
  	location.href = window.favorited_course

  $(".course-more").click ->
  	# jump to enrolled course page 
  	location.href = window.enrolled_course

  $('.home').click ->
    location.href = window.home

  if $('.course-div.enrolled-course').find('.favorite-item').length >= 3
    $('.course-more').show()

  if $('.favorite-div').find('.favorite-item').length >= 3
    $('.favorite-more').show()

  $(".category-class").each ->
    if $(this).text() == "分类N"
      $(this).addClass('health-title')
    else if $(this).text() == "分类t"
      $(this).addClass('psychology-title')
    else
      $(this).addClass('grow-title')

  $('.favorite-item').click ->
    cid = $(this).attr('data-id')
    location.href = window.course + "/" +cid 

  $('.enrolled-course').find(".favorite-item:gt(2)").hide()

  $('.favorite-div').find(".favorite-item:gt(2)").hide()
