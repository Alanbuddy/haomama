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

  # signup = ->
  #   if $("#signup_btn").attr("disabled") == true
  #     return
  #   phone = $("#mobile").val()
  #   verify_code = $("#mobilecode").val()
  #   password = $("#password").val()
  #   password_again = $("#password_again").val()
  #   if password != password_again
  #     toggle_password_tip(true)
  #     return
  #   $.postJSON(
  #     window.register,
  #     {
  #       phone: phone
  #       password: password
  #       password_confirmation: password_again
  #       captcha: verify_code
  #     },
  #     (data) ->
  #       console.log(data)
  #       if data.success
  #         $(".input-div input").val("")
  #         location.href = window.login
  #       # else
  #       #   if data.code == WRONG_VERIFY_CODE
  #       #     $("#code_notice").text("验证码错误").css("visibility", "visible")
  #       #   if data.code == USER_NOT_EXIST
  #       #     $("#mobile_notice").text("账号不存在").css("visibility", "visible")
  #     )

  # $("#signup_btn").click ->
  #   signup()
  #   return false
  # $("#password_again").keydown (event) ->
  #   code = event.which
  #   if code == 13
  #     signup()

  $("#jump_to_signin").click ->
    location.href = window.login






