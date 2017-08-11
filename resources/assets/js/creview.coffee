
$ ->
  $(document).scroll ->
    if $(document).scrollTop() > 200
      $('.upper').fadeIn(1000)
    else
      $('.upper').fadeOut(1000)

  $('.upper').click ->
    $('body').animate({scrollTop: 0})
    $(".notice").hide()

  check_review_input = ->
    if $(".review-input").val() == ""
      $("#delivery").attr("disabled", true).css("opacity", "0.5")
    else
      $("#delivery").attr("disabled", false).css("opacity", "1")

  $(".review-input").keyup ->
    check_review_input()

  $(".nav li").click ->
    $(".nav li").removeClass("active")
    $(this).addClass("active")
    $(".main-div").css("display", "none")
    $(".main-div").eq($(this).index()).css("display", "block")

  $(".back").click ->
    location.href = window.course

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

  $(".nums-div a").each ->
    index = $(this).attr("data-index")
    $(this).siblings("a").removeClass("red-border")
    $(this).siblings("a").find("span").css("color", "#999")
    $(".nums-div a").eq(index).addClass("red-border").find("span").css("color", "#333")

  $(".time").each ->
    data_time = $(this).text()
    dtime = Date.parse(data_time)
    dt = new Date(dtime)
    dy = dt.getFullYear()
    dm = dt.getMonth() + 1
    dd = dt.getDate()
    time_now = Date.parse(Date())
    time = (time_now - dtime)/1000
    if time < 60
      $(this).text(time + "秒前")
    else if 60 <= time < 3600
      $(this).text(Math.round(time/60) + "分前")
    else if 3600 <= time <  86400
      $(this).text(Math.round(time/3600) + "小时前")
    else if 86400 <= time < 604800
      $(this).text(Math.round(time/86400) + "天前")
    else
      $(this).text(dy + "年" + dm + "月" + dd + "日")


    




