$ ->
	$(".details").click ->
    span = $(this).find("span")
    row = $(this).closest("tr")
    cid = row.attr("data-id")
    status = row.next()
    status.toggle()
    if span.hasClass("triangle-down")
      span.removeClass("triangle-down").addClass("triangle-up")
    else
      span.removeClass("triangle-up").addClass("triangle-down")
    

  $("#desc").click ->
    location.href = window.client_desc