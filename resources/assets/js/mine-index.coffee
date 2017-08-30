$ ->

  $(".avatar-div").click ->
  	# jump to profile_page
    location.href = window.profile

  $(".message-icon").click ->
  	# juml to messgae_page
  	location.href = window.message

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


  $('.favorite-item').click ->
    cid = $(this).attr('data-id')
    location.href = window.course + "/" +cid 

  $('.item').click ->
    c_id = $(this).attr('data-id')
    location.href = window.course + "/" +c_id 

  $('.enrolled-course').find(".favorite-item:gt(2)").hide()

  $('.favorite-div').find(".favorite-item:gt(2)").hide()

  sign_in = ->
    wx.scanQRCode
      needResult: 1
      scanType: ["qrCode"]
      success: (res) ->
        result = res.resultStr
        window.location.href = result

  $(".item-right").click ->
    sign_in()

