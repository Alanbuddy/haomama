
$ ->

  $(".course-nav span").click ->
    $(this).closest(".swiper-slide").find(".course-nav span").removeClass('course-active')
    $(this).addClass('course-active')
    $(this).closest(".swiper-slide").find(".course-item-div").css('display', 'none');
    $(this).closest(".swiper-slide").find(".course-item-div").eq($(this).index()).css('display', 'block')

  $("#home").click ->
    # jump to home_page
    location.href = ""

  $("#mine").click ->
    # jump to mine_page
    location.href = ""

  search = ->
    val = $(".search-input").val()
    # jump to search_page
    location.href = ""

  $(".search").click ->
    search()

  $(".search-input").keydown (event) ->
    code = event.which
    if code == 13
      search()

  mySwiper = new Swiper('.swiper-container',{
    speed: 300,
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

