
$ ->

  check_review_input = ->
    if $(".review-input").val() == ""
      $("#delivery").attr("disabled", true).css("opacity", "0.5")
    else
      $("#delivery").attr("disabled", false).css("opacity", "1")

  $(".review-input").keyup ->
    check_review_input()

  $(".nav li").click ->
    $(".nav li").removeClass("active")
    $(this).addClass("active")
    $(".main-div").css("display", "none")
    $(".main-div").eq($(this).index()).css("display", "block")


    




