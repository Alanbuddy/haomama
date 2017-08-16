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
    $.ajax({
      type: 'get',
      url: window.attendence,
      success: (data) ->


      }) 

  tem_str = `<div class="course-status">
              <span class="item-status">上课状态:</span>
              <span class="join-status"></span>
              <span class="miss-status"></span>
              <span class="square"></span>
            </div>`
  tem = $(tem_str)
  render = (item) ->
    tem.find(".square")

  $("#desc").click ->
    location.href = window.client_desc