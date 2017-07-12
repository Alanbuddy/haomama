$ ->
  $(".lesson-video").click ->
    location.href = window.lesson_store + "?/type=video"

  $(".lesson-audio").click ->
    location.href = window.lesson_store + "?type=audio"

  $(".show-name").click ->
    location.href = "/lessons/1"