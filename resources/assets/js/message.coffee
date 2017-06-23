$ ->
  $(".time").each ->
    data_time = $(this).text()
    dtime = Date.parse(data_time)
    dt = new Date(dtime)
    dy = dt.getFullYear()
    dm = dt.getMonth() + 1
    dd = dt.getDate()
    time_now = Date.parse(Date())
    time = time_now - dtime
    _this = $(this)
    if time < 60000
      _this.text(time/1000 + "秒前")
    else if 60000 < time < 3600000
      _this.text(time/60000 + "分前")
    else if 3600000 < time <  86400000
      _this.text(time/3600000 + "小时前")
    else if 86400000 < time < 604800000
      _this.text(time/86400000 + "天前")
    else
      _this.text(dy + "年" + dm + "月" + dd + "日")