$ ->
  $(document).scroll ->
    if $(document).scrollTop() > 100
      $('.upper').fadeIn(1000)
    else
      $('.upper').fadeOut(1000)

  $('.upper').click ->
    $('body').animate({scrollTop: 0})

	$("#another-baby").click ->
    baby_dom = document.createElement("div")
    $(baby_dom).addClass("baby-item").html($(".add-baby-div").html())
    $(baby_dom).insertBefore("#another-baby")

  $(document).on 'click', '.close-add-item', ->
    $(this).closest('.baby-item').hide()

  change_avatar = (gender, birthday, object) ->
    today = new Date()
    if gender == "男子汉" && (today.getFullYear() - birthday.getFullYear()) > 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/kid_male.png')
    if gender == "男子汉" && (today.getFullYear() - birthday.getFullYear()) <= 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/baby_male.png')
    if gender == "小姑娘" && (today.getFullYear() - birthday.getFullYear()) > 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/kid_female.png')
    if gender == "小姑娘" && (today.getFullYear() - birthday.getFullYear()) <= 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/baby_female.png')

  $(document).on 'change', '.birthday', ->
    birthday = $(this).val()
    birthday = new Date(birthday)
    gender = $(this).closest('.row-div').siblings('.row-div').find('.gender').val()
    change_avatar(gender, birthday, this)

  $(document).on 'change', '.gender', ->
    gender = $(this).val()
    birthday = $(this).closest('.row-div').siblings('.row-div').find('.birthday').val()
    birthday = new Date(birthday)
    change_avatar(gender, birthday, this)

  $('.favorite').click ->
    fav = $(this).attr('data-fav')
    $.getJSON(
      window.favorite,
      {},
      (data) ->
        console.log(data)
        if data.success
          if fav == "false"
            $('.favorite').attr('src', '/icon/like_selected.png')
            $('.favorite').attr('data-fav', 'true')
            showMsg('成功收藏该课程', 'center')
          else
            $('.favorite').attr('src', '/icon/like_normal.png')
            $('.favorite').attr('data-fav', 'false')
            showMsg('收藏已取消', 'center')
        else
          showMsg('服务器出错，请稍后再试', 'center')
      )

  $('.admire-icon').click ->
    url = $(this).closest(".review-item").attr("data-url")
    num = $(this).siblings(".admire-num").text()
    ad = $(this)
    $.getJSON(
      url,
      {},
      (data) ->
        console.log(data)
        if data.success
          if data.message == 'yes'
            ad.attr('src', '/icon/like1_selected.png')
            ad.siblings(".admire-num").text(parseInt(num) + 1)
            showMsg('点赞完成', 'center')
          else
            ad.attr('src', '/icon/like1_normal.png')
            ad.siblings(".admire-num").text(parseInt(num) - 1)
            showMsg('取消点赞', 'center')
        else
          showMsg('服务器出错，请稍后再试', 'center')
      )

  $('.category-class').each ->
    if $(this).text() == "分类N"
      $(this).addClass('health-title-small')
    else if $(this).text() == "分类t"
      $(this).addClass('psychology-title-small')
    else
      $(this).addClass('grow-title-small')

  $(".online-course .item:eq(0)").attr("data-status", "publish")

  $(".online-course .item").each ->
    hasEnrolled = $(this).attr("data-enrolled")
    if hasEnrolled == false
      $(this).addClass("opt55")

  $(".items-div > .item:gt(2)").hide()

  $(".view-more").click ->
    $(this).siblings(".item").slideDown()
    $(this).hide()

  $(".items-div > .teacher-item:gt(2)").hide()

  $(".view-more").click ->
    $(this).siblings(".teacher-item").slideDown()
    $(this).hide()

  $(".course-item").click ->
    cid = $(this).attr("data-id")
    location.href = window.course_item + "/" +cid

  $(".back").click ->
    location.href = history.back()


