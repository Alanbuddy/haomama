
$ ->
  $("#to_signup").click ->
    $("input").val("")
    location.href = window.register
  $("#to_forget_password").click ->
    $("input").val("")
    location.href = window.forget
  $("#signin_btn").attr("disabled", true)

  toggle_signin_tip = (wrong) ->
    if (wrong)
      $("#error_notice").css("visibility", "visible")
    else
      $("#error_notice").css("visibility", "hidden")

  check_signin_input = ->
    if $("#mobile").val().trim() == "" ||
        $("#password").val().trim() == ""
      $("#signin_btn").attr("disabled", true)
    else
      $("#signin_btn").attr("disabled", false)

  $("#mobile").keyup (event) ->
    code = event.which
    if code != 13
      toggle_signin_tip(false)   
    check_signin_input()
  $("#password").keyup (event) ->
    code = event.which
    if code != 13
      toggle_signin_tip(false)
    check_signin_input()

   
