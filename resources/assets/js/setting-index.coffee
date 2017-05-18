
$ ->
  $(".edit").click ->
    $(this).hide()
    parent = $(this).closest(".right-div")
    span = parent.find("span")
    input = parent.find("input")
    select = parent.find("select")
    replaec = parent.find(".replace")
    span.toggle()
    input.toggle()
    select.toggle()
    replaec.toggle()
    $("#edit-end").show()

  # $(".replace").click ->
  #   $("#mobileModal").modal("show")

  # $("#another-baby").click ->
  #   baby_dom = document.createElement("div")
  #   $(baby_dom).addClass("item").html($(".baby-div").html())
  #   $(baby_dom).insertBefore("#another-baby")

    