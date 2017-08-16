$ ->
	$(".details").click ->
    span = $(this).find("span")
    row = $(this).closest("tr")
    status = row.next()
    status.toggle()
    if span.hasClass("triangle-down")
      span.removeClass("triangle-down").addClass("triangle-up")
    else
      span.removeClass("triangle-up").addClass("triangle-down")  

  $("#pay").click ->
    location.href = window.client_purchase

  $("#desc").click ->
    location.href = window.client_desc