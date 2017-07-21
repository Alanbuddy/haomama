$ ->

   

  $("#register-message").click ->
    $("#unshelve-btn").hide()
    $("#edit-btn").hide()
    $("#finish-btn").hide()
    $("#shelve-btn").hide()

  $("#course-comment").click ->
    $("#unshelve-btn").hide()
    $("#edit-btn").hide()
    $("#finish-btn").hide()
    $("#shelve-btn").hide()

  $("#course-desc").click ->
    $("#unshelve-btn").show()
    $("#shelve-btn").show()
    if is_edit
      $("#finish-btn").show()
    else
      $("#edit-btn").show()


# 显示/隐藏评论
  # $(document).on 'click', '.hide-review', ->
  #   rid = $(this).attr("data-id")
  #   hide_review(rid, $(this))

  # $(document).on 'click', '.show-review', ->
  #   rid = $(this).attr("data-id")
  #   show_review(rid, $(this))

  # show_review = (rid, ele) ->
  #   $.postJSON(
  #     '/staff/reviews/' + rid + '/show_review',
  #     { },
  #     (data) ->
  #       if data.success
  #         $.page_notification("设置完成")
  #         ele.removeClass("show-review").addClass("hide-review")
  #         ele.text("隐藏评论")
  #       else
  #         $.page_notification("服务器出错")
  #     )

  # hide_review = (rid, ele) ->
  #   $.postJSON(
  #     '/staff/reviews/' + rid + '/hide_review',
  #     { },
  #     (data) ->
  #       if data.success
  #         $.page_notification("设置完成")
  #         ele.removeClass("hide-review").addClass("show-review")
  #         ele.text("公开评论")
  #       else
  #         $.page_notification("服务器出错")
  #     )
  
# 上下架
  # $(".operation").click ->
  #   current_state = "unavailable"
  #   if $(this).hasClass("delete-normal")
  #     current_state = "available"
  #   btn = $(this)
  #   $.postJSON(
  #     '/staff/courses/' + window.cid + '/set_available',
  #     {
  #       available: current_state == "unavailable"
  #     },
  #     (data) ->
  #       if data.success
  #         $.page_notification("操作完成")
  #         if current_state == "available"
  #           btn.removeClass("delete-normal")
  #           btn.addClass("new-normal")
  #           btn.text("上架")
  #         else
  #           btn.addClass("delete-normal")
  #           btn.removeClass("new-normal")
  #           btn.text("下架")
  #       else
  #         if data.code == COURSE_PARTICIPATE_EXIST
  #           $.page_notification("该课程有人报名参加，不能下架", 1000)
  #     )
