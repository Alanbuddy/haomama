$ ->
  # viewHeight = window.innerHeight     
  # $("input").focus( ->
  #   $(".wrapper").css("height", viewHeight)
  # ).blur(->
  #   $(".wrapper").css("height", "100%")
  # )
  document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px'