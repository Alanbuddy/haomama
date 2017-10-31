$ ->
  
  $("#signup_btn").attr("disabled", true)

  toggle_password_tip = (wrong) ->
    if (wrong)
      $("#password_notice").css("visibility", "visible")
    else
      $("#password_notice").css("visibility", "hidden")

  check_signup_input = ->
    if $("#mobile").val().trim() == "" ||
        $("#mobilecode").val().trim() == "" ||
        $("#password").val().trim() == "" ||
        $("#password_again").val().trim() == ""
      $("#signup_btn").attr("disabled", true)
    else
      $("#signup_btn").attr("disabled", false)

  $("#mobile").keyup ->
    check_signup_input()
    $("#mobile_notice").css("visibility", "hidden")
  $("#mobilecode").keyup ->
    check_signup_input()
    $("#code_notice").css("visibility", "hidden")
  $("#password").keyup ->
    check_signup_input()
    $("#password_notice").css("visibility", "hidden")
  $("#password_again").keyup ->
    check_signup_input()
    $("#password_notice").css("visibility", "hidden")

  $("#password").keyup (event) ->
    code = event.which
    if code != 13
      toggle_password_tip(false)
    check_signup_input()
  $("#password_again").keyup (event) ->
    code = event.which
    if code != 13
      toggle_password_tip(false)
    check_signup_input()

  $("#jump_to_signin").click ->
    location.href = window.login






