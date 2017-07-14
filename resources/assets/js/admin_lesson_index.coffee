$ ->
  $(".lesson-video").click ->
    location.href = window.lesson_create + "?/type=video"

  $(".lesson-audio").click ->
    location.href = window.lesson_create + "?type=audio"

  $(".show-name").click ->
    location.href = "/admin/lessons/1"