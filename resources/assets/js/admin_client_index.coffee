$ ->
	$(".age").each ->
    birthday = $(this).text();
    if birthday != "无"
      birthday = birthday.substring(0, 4)
      td = new Date()
      t_year = td.getFullYear()
      age = t_year - birthday
      if age == 0
        age = "不足一岁"
      else 
        age = age + "岁"
      $(this).text(age)

  search = ->
    value = $("#search-input").val()
    location.href = window.client_index + "?key=" + value

  $("#search-btn").click ->
    search()


  $("#search-input").keydown (event) ->
    code = event.which
    if code == 13
      search()