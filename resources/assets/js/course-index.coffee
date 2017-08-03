$ ->
  $('.swiper-container').scroll ->
    if $('.swiper-container').scrollTop() > 100
      $('.upper').fadeIn(1000)
    else
      $('.upper').fadeOut(1000)

  $('.upper').click ->
    $('.swiper-container').animate({scrollTop: 0})

  $('.nav li').eq(0).addClass('active')

  $(".course-nav span").click ->
    $(this).closest(".swiper-slide").find(".course-nav span").removeClass('course-active')
    $(this).addClass('course-active')
    $(this).closest(".swiper-slide").find(".course-item-div").css('display', 'none');
    $(this).closest(".swiper-slide").find(".course-item-div").eq($(this).index()).css('display', 'block')

  $("#mine").click ->
    # jump to mine_page
    location.href = window.userid

  search = ->
    val = $(".search-input").val()
    # jump to search_page
    location.href = window.course_search

  $(".search").click ->
    search()

  $(".search-input").click ->
    location.href = window.course_search
    
  mySwiper = new Swiper('.swiper-container',{
    speed: 300,
    setWrapperSize :true,
    followFinger : false,
    shortSwipes : false,
    touchAngle : 10,
    longSwipes : false,
    onSlideChangeStart : ->
      $(".nav li").removeClass('active')
      $(".nav li").eq(mySwiper.activeIndex).addClass('active')
  })

  $(".nav li").on('touchstart mousedown', (e) ->
    e.preventDefault()
    $(".nav li").removeClass('active')
    $(this).addClass('active')
    mySwiper.slideTo($(this).index())
  )
  
  $(".nav li").click( (e) ->
    e.preventDefault()
  )

  bannerSwiper = new Swiper('.swiper-container-banner',{
    pagination : '.swiper-pagination',
    autoplay: 3000, 
    loop: true,
  })

  $('.course-item').click ->
    cid = $(this).attr('data-id')
    location.href = window.course_item + "/" +cid

  $('.category-class').each ->
    if $(this).text() == "·ÖÀàN"
      $(this).addClass('health-title')
    else if $(this).text() == "·ÖÀàt"
      $(this).addClass('psychology-title')
    else
      $(this).addClass('grow-title')
