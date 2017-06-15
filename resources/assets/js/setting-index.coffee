
$ ->

  # parent_edit = false
  # baby_edit = false
  # $('#parent-edit').click ->
  #   parent_edit = true
  #   $(this).hide()
  #   parent = $(this).closest(".right-div")
  #   span = parent.find("span")
  #   select = parent.find("select")
  #   replace = parent.find(".replace")
  #   span.toggle()
  #   select.toggle()
  #   replace.toggle()
  #   $('#edit-end').show()

  # $(".edit").click ->
  #   baby_edit = true
  #   $(this).hide()
  #   parent = $(this).closest(".right-div")
  #   span = parent.find("span")
  #   input = parent.find("input")
  #   select = parent.find("select")
  #   span.toggle()
  #   input.toggle()
  #   select.toggle()
  #   $('#another-baby').show()
  #   $("#edit-end").show()
  #  分割
    # $("#another-baby").hide()
    # replaec = parent.find(".replace")
    # close = $(this).closest(".item").find(".baby-close").toggle()
    # replaec.toggle()
    # if $(this).attr("id") == "baby-edit"
    #   $("#edit-end").attr("data-edit", "baby-edit")
    # else if $(this).attr("id") == "parent-edit"
    #   $("#edit-end").attr("data-edit", "parent-edit")



  # $(document).on 'click', '.close-add-item', ->
  #   $(this).closest('.item').hide()
  #   if parent_edit == false && baby_edit == false && $('.item:visible').length == 2
  #     $('#edit-end').hide()
   

  

  change_avatar = (gender, birthday, object) ->
    today = new Date()
    if gender == "男子汉" && (today.getFullYear() - birthday.getFullYear()) > 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/kid_male.png')
    if gender == "男子汉" && (today.getFullYear() - birthday.getFullYear()) <= 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/baby_male.png')
    if gender == "小姑娘" && (today.getFullYear() - birthday.getFullYear()) > 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/kid_female.png')
    if gender == "小姑娘" && (today.getFullYear() - birthday.getFullYear()) <= 3
      $(object).closest('.right-div').siblings('.left-div').find('img').attr('src', '/icon/baby_female.png')

  $(document).on 'change', '.birthday', ->
    birthday = $(this).val()
    birthday = new Date(birthday)
    gender = $(this).closest('.row-div').siblings('.row-div').find('.gender').val()
    change_avatar(gender, birthday, this)

  $(document).on 'change', '.gender', ->
    gender = $(this).val()
    birthday = $(this).closest('.row-div').siblings('.row-div').find('.birthday').val()
    birthday = new Date(birthday)
    change_avatar(gender, birthday, this)

  $(".back").click ->
    location.href = window.mine_page


  




    