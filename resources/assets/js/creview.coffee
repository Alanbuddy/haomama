
$ ->
  $("li").click ->
    $(this).siblings().removeClass("active")
    $(this).addClass("active")

  check_review_input = ->
    if $(".review-input").val() == ""
      $("#delivery").attr("disabled", true).css("opacity", "0.5")
    else
      $("#delivery").attr("disabled", false).css("opacity", "1")

  $(".review-input").keyup ->
    check_review_input()



