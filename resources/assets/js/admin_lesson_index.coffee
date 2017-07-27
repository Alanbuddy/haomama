$ ->
  $(".lesson-video").click ->
    location.href = window.lesson_create + "?type=video"

  $(".lesson-audio").click ->
    location.href = window.lesson_create + "?type=audio"

  $("#video").click ->
  	location.href = window.lesson_index + "?type=video"

  $("#audio").click ->
  	location.href = window.lesson_index + "?type=audio"
