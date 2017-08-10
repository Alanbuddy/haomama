$ ->
  $(".list-div").eq(0).css("display", "block")
  
  $('.wrapper').scroll ->
    if $('.wrapper').scrollTop() > 100
      $('.upper').fadeIn(1000)
    else
      $('.upper').fadeOut(1000)

  $('.upper').click ->
    $('.wrapper').animate({scrollTop: 0})

  $('.nav li').eq(0).addClass('active')

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

  $(".nav li").click ->
    i = $(this).index()
    $(".nav li").removeClass('active')
    $(this).addClass('active')
    $(".list-div").css("display", "none")
    $(".list-div").eq(i).css("display", "block")
    $(".list-div").eq(i).find(".course-nav span").click ->
      $(".list-div").eq(i).find(".course-nav span").removeClass('course-active')
      $(this).addClass('course-active')
      $(".list-div").eq(i).find(".course-item-div").css('display', 'none');
      $(".list-div").eq(i).find(".course-item-div").eq($(this).index()).css('display', 'block')
  
  $(".list-div").eq(0).find(".course-nav span").click ->
    $(".list-div").eq(0).find(".course-nav span").removeClass('course-active')
    $(this).addClass('course-active')
    $(".list-div").eq(0).find(".course-item-div").css('display', 'none');
    $(".list-div").eq(0).find(".course-item-div").eq($(this).index()).css('display', 'block')

  bannerSwiper = new Swiper('.swiper-container-banner',{
    pagination : '.swiper-pagination',
    autoplay: 3000, 
    loop: true,
  })

  $('.course-item').click ->
    cid = $(this).attr('data-id')
    location.href = window.course_item + "/" +cid

