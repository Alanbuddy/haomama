$ ->
  $(".avatar-div").click ->
  	# jump to profile_page
    location.href = ""

  $(".message-icon").click ->
  	# juml to messgae_page
  	location.href = ""

  $(".item-right").click ->
  	# jump to signin_page
  	location.href = ""

  $(".favorite-more").click ->
  	# jump to favorite page 
  	location.href = ""

  $(".course-more").click ->
  	# jump to favorite course page 
  	location.href = ""

  if $('.course-div.mine-course').find('.favorite-item').length >= 3
    $('.course-more').show()

  if $('.favorite-div').find('.favorite-item').length >= 3
    $('.favorite-more').show()
