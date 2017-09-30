$ ->

  $("#to_signin").click ->
    $("input").val("")
    location.href = window.login

  $("#confirm_btn").attr("disabled", true)

  toggle_password_tip = (wrong) ->
    if (wrong)
      $("#password_notice").css("visibility", "visible")
    else
      $("#password_notice").css("visibility", "hidden")

  check_forget_input = ->
    if $("#mobile").val().trim() == "" ||
        $("#mobilecode").val().trim() == "" ||
        $("#password").val().trim() == "" ||
        $("#password_again").val().trim() == ""
      $("#confirm_btn").attr("disabled", true)
    else
      $("#confirm_btn").attr("disabled", false)

  $("#mobile").keyup ->
    check_forget_input()
    $("#mobile_notice").css("visibility", "hidden")
  $("#mobilecode").keyup ->
    check_forget_input()
    $("#code_notice").css("visibility", "hidden")
  $("#password").keyup ->
    check_forget_input()
    $("#password_notice").css("visibility", "hidden")
  $("#password_again").keyup ->
    check_forget_input()
    $("#password_notice").css("visibility", "hidden")

  $("#password").keyup (event) ->
    code = event.which
    if code != 13
      toggle_password_tip(false)
    check_forget_input()
  $("#password_again").keyup (event) ->
    code = event.which
    if code != 13
      toggle_password_tip(false)
    check_forget_input()
