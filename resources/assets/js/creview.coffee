
$ ->

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

  $(".nums-div a").each ->
    index = $(this).attr("data-index")
    $(this).siblings("a").removeClass("red-border")
    $(".nums-div a").eq(index).addClass("red-border")




    




