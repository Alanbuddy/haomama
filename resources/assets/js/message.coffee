$ ->
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

  $(".back").click ->
    location.href = window.person_show