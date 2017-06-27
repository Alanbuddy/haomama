$ ->
  $(".sidebar ul li:eq(0)").addClass("active-li")
  $(".sidebar ul li").each ->
    that = $(this)
    $(this).click ->
      that.siblings("li").removeClass("active-li")
      that.addClass("active-li")
