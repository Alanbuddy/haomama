
$ ->
  is_add = false
  $(".edit").click ->
    $(".edit").hide()
    $("#another-baby").hide()
    parent = $(this).closest(".right-div")
    span = parent.find("span")
    input = parent.find("input")
    select = parent.find("select")
    replaec = parent.find(".replace")
    close = $(this).closest(".item").find(".baby-close").toggle()
    span.toggle()
    input.toggle()
    select.toggle()
    replaec.toggle()
    $("#edit-end").show()
    if $(this).attr("id") == "baby-edit"
      $("#edit-end").attr("data-edit", "baby-edit")
    else if $(this).attr("id") == "parent-edit"
      $("#edit-end").attr("data-edit", "parent-edit")

  $("#edit-end").click ->
    console.log($(this).attr("data-edit"))
    #update
    if $(this).attr("data-edit") == "parent-edit"
      parent_statu = $("#parent").val()
      mobile = $("#mobile-span").text()
    if $(this).attr("data-edit") == "baby-edit"
      # baby_id = "已有id"   需添加原有id
      baby_name = $("#baby-name").val()
      baby_gender = $("#baby-gender").val()
      baby_birthday = $("#baby-birthday").val()

    #create
    if is_add
      add_baby_name = $("#add-baby-name").val()
      add_baby_gender = $("#add-baby-gender").val()
      add_baby_birthday = $("#add-baby-birthday").val()

      console.log(add_baby_name, add_baby_gender, add_baby_birthday )
    $.postJSON(
      url,
      {},
      (data) ->
      )

  $(document).on 'click', '.close-add-item', ->
    $(this).closest('.item').hide()
    $("#edit-end").hide()
    $(".edit").show()

  $("#another-baby").click ->
    is_add = true
    $(this).hide()
    $(".edit").hide()
    baby_dom = document.createElement("div")
    $(baby_dom).addClass("item").html($(".add-baby-div").html())
    $(baby_dom).insertBefore("#another-baby")
    $("#edit-end").show()
    console.log(is_add)


  




    