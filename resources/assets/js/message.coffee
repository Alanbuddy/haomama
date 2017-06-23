$ ->
  $(".time").each ->
    data_time = $(this).attr("data-time")
    time = parseInt($(this).text())
    _this = $(this)
    if time < 60
      _this.text(time + "秒前")
    else if 60 < time < 3600
      _this.text(time/60 + "分前")
    else if 3600 < time <  86400
      _this.text(time/3600 + "小时前")
    else if 86400 < time < 604800
      _this.text(time/7 + "天前")
    else
      _this.text()