$ ->
  $(".height-div").css("height", window.screen.availHeight - $("#profileModal .head-div").height())

  $(document).scroll ->
    if $(document).scrollTop() > 100
      $('.upper').fadeIn(1000)
    else
      $('.upper').fadeOut(1000)

  $('.upper').click ->
    $('body').animate({scrollTop: 0})
    $(".notice").hide()

	$("#another-baby").click ->
    baby_dom = document.createElement("div")
    $(baby_dom).addClass("baby-item").html($(".add-baby-div").html())
    $(baby_dom).insertBefore("#another-baby")

  $(document).on 'click', '.close-add-item', ->
    $(this).closest('.baby-item').hide()

  change_avatar = (gender, birthday, object) ->
    today = new Date()
    if gender == "男子汉" && (today.getFullYear() - birthday.getFullYear()) > 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', 'icon/kid_male.png')
    if gender == "男子汉" && (today.getFullYear() - birthday.getFullYear()) <= 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', 'icon/baby_male.png')
    if gender == "小姑娘" && (today.getFullYear() - birthday.getFullYear()) > 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', 'icon/kid_female.png')
    if gender == "小姑娘" && (today.getFullYear() - birthday.getFullYear()) <= 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', 'icon/baby_female.png')

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
            $('.favorite').attr('src', 'icon/like_selected.png')
            $('.favorite').attr('data-fav', 'true')
            showMsg('成功收藏该课程', 'center')
          else
            $('.favorite').attr('src', 'icon/like_normal.png')
            $('.favorite').attr('data-fav', 'false')
            showMsg('收藏已取消', 'center')
        else
          showMsg('服务器出错，请稍后再试', 'center')
      )

  $(document).on 'click', '.admire-icon', ->
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
            ad.attr('src', 'icon/like1_selected.png')
            ad.siblings(".admire-num").text(parseInt(num) + 1)
            showMsg('点赞完成', 'center')
          else
            ad.attr('src', 'icon/like1_normal.png')
            ad.siblings(".admire-num").text(parseInt(num) - 1)
            showMsg('取消点赞', 'center')
        else
          showMsg('服务器出错，请稍后再试', 'center')
      )

  $('.category-class').each ->
    if $(this).text() == "健康养育"
      $(this).addClass('health-title-small')
    else if $(this).text() == "心理教育"
      $(this).addClass('psychology-title-small')
    else
      $(this).addClass('grow-title-small')

  $(".online-course .item:eq(0)").attr("data-status", "publish")

  $(".online-course .item").each ->
    hasEnrolled = $(this).attr("data-enrolled")
    if hasEnrolled == false
      $(this).addClass("opt55")

  $(".offline-lesson .item:eq(0)").attr("data-status", "publish")

  $(".offline-lesson .item").each ->
    offline_hasEnrolled = $(this).attr("data-enrolled")
    if offline_hasEnrolled == false
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
    location.href = window.course

  $(".time").each ->
    data_time_show = $(this).text()
    dtime_show = Date.parse(data_time_show)
    dt_show = new Date(dtime_show)
    dy_show = dt_show.getFullYear()
    dm_show = dt_show.getMonth() + 1
    dd_show = dt_show.getDate()
    time_now_show = Date.parse(Date())
    time_show = (time_now_show - dtime_show)/1000
    if time_show < 60
      $(this).text(time_show + "秒前")
    else if 60 <= time_show < 3600
      $(this).text(Math.round(time_show/60) + "分前")
    else if 3600 <= time_show <  86400
      $(this).text(Math.round(time_show/3600) + "小时前")
    else if 86400 <= time_show < 604800
      $(this).text(Math.round(time_show/86400) + "天前")
    else
      $(this).text(dy_show + "年" + dm_show + "月" + dd_show + "日")

  $(".course-time").each ->
    if $(this).text() == "无时间"
      $(this).text() == "无时间"
    else
      course_begin = $(this).text()
      course_end = $(this).attr("time-end")
      cb = Date.parse(course_begin)
      ce = Date.parse(course_end)
      ctime = (cb - ce)/1000
      console.log(ctime);
      if ctime < 60
        $(this).text(ctime + "sec")
      else if 60 <= ctime < 3600
        $(this).text(Math.round(ctime/60) + "min")
      else
        $(this).text(Math.floor(ctime/3600) + "h" + Math.round((ctime%3600)/60) + "m")

  $(".star-div input").attr("checked", "checked")




