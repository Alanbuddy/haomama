$ ->
  $(".sidebar ul li:eq(0)").addClass("active-li")
  $(".sidebar ul li").each ->
    that = $(this)
    $(this).click ->
      that.siblings("li").removeClass("active-li")
      that.addClass("active-li")

  $("#exit").click ->
    $.ajax({
      type: 'post',
      url: window.logout,
      data: {_token: window.token},
      async: false,
      success: ->
        location.href = window.login
    })
