$ ->
  $("#scan").click ->
    wx.scanQRCode
      needResult: 1
      scanType: ["qrCode"]
      success: (res) ->
        result = res.resultStr
        window.location.href = result

  $("#view").click ->
    cid = $(this).attr("data-id")
    location.href = window.course_item + "/" + cid
