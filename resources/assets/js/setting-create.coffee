
$ ->
  uid = ""
  timer = null
  wait = 60
  time = (o) ->
    $(o).attr("disabled", true)
    if wait == 0
      $(o).attr("disabled", false)
      $(o).text('获取验证码')
      wait = 60
    else
      $(o).text('重发(' + wait + ')')
      wait--
      timer = setTimeout (->
        time o
        return
      ), 1000
    return

  # $("#code").clcik ->
  #   mobile = $("#mobile").val()
  #   mobile_retval = $.regex.isMobile(mobile)
  #   if mobile_retval == false
  #     $.mobile_page_notification("手机号不正确", 1000)
  #     return false
  #   $.postJSON(
  #     url,
  #     {
  #       mobile: mobile
  #       captcha: captcha
  #     },
  #     (data) ->
  #       if data.success
  #         uid = data.uid
  #         if timer != null
  #           clearTimeout(timer)
  #         time("#code")
  #       #需要修改
  #       else
          
  #   )
  #   return false

  $("#another-baby").click ->
    baby_dom = document.createElement("div")
    $(baby_dom).addClass("item-baby-div").html($(".item-baby-div").html())
    $(baby_dom).insertBefore("#another-baby")

