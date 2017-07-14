$ ->
  # 侧边栏sidebar高亮显示
  currenturl = window.location.href
  $(".sidebar ul li a").each ->
    url = $(this).attr("href")
    if currenturl.indexOf(url) != -1
      $(this).closest("li").addClass("active-li")

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
  

