$ ->
  # 侧边栏sidebar高亮显示
  currenturl = window.location.href
  $(".sidebar ul li a").each ->
    url = $(this).attr("href")
    if currenturl.indexOf(url) != -1 && currenturl.indexOf("type=teacher") != -1 
      $(this).closest("li.teacher_li").addClass("active-li")
    else if currenturl.indexOf(url) != -1&& (!/\d/.test(currenturl[currenturl.indexOf(url)-1]))
      $(this).closest("li").not(".teacher_li").addClass("active-li")
    if currenturl.indexOf("users") != -1 && currenturl.indexOf("type=teacher") != -1
      $(this).closest("li.teacher_li").addClass("active-li")
    if currenturl.indexOf("settings") != -1 
      $(this).closest("li.setting_li").addClass("active-li")
    if(/admin\/teachers/.test(currenturl)&&$(this).attr('href')=='/users?type=teacher')
      $(this).closest("li.teacher_li").addClass("active-li")
    if(/operator/.test(currenturl))
      $(this).closest("li.user_li").removeClass("active-li")


  # 退出登录
  $("#exit").click ->
    $.ajax({
      type: 'post',
      url: window.logout,
      data: {_token: window.token},
      async: false,
      success: ->
        location.href = window.login
    })
  

