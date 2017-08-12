
$ ->
  $(".back").click ->
    location.href = history.back()

  $('.category-class').each ->
    if $(this).text() == "·ÖÀàN"
      $(this).addClass('health-title')
    else if $(this).text() == "·ÖÀàt"
      $(this).addClass('psychology-title')
    else
      $(this).addClass('grow-title')

  $(".course-item").click ->
    cid = $(this).attr("data-id")
    location.href = window.course_item + "/" +cid

  $(".admire-icon").click ->
    num = $(this).siblings("span").text()
    _this = $(this)
    $.getJSON(
      window.vote,
      {},
      (data) ->
        console.log(data)
        if data.success
          if data.message == "yes"
            _this.attr("src", "icon/like2_selected.png")
            _this.siblings("span").text(parseInt(num) + 1).css("color", "#ccc")
            _this.closest(".admire-div").css("border-color", "#ccc")
            showMsg("点赞完成", "center")
          else
            _this.attr('src', 'icon/like2_normal.png')
            _this.siblings("span").text(parseInt(num) - 1).css("color", "#fc90a5")
            _this.closest(".admire-div").css("border-color", "#fc90a5")
            showMsg("取消点赞", "center")
        else
          showMsg('服务器出错，请稍后再试', 'center')
      )

  votes = $(".admire-div span").text()
  if votes.length < 4
    $(".admire-div span").text(votes)
  else if 4 <= votes.length < 5
    votes = votes/1000.toFixed(1)
    $(".admire-div span").text(votes + "K")
  else if 5 <= votes.length < 6
    votes = Math.floor(votes/1000)
    $(".admire-div span").text(votes + "K")
  else
    votes = Math.floor(votes/10000)
    $(".admire-div span").text(votes + "W")
