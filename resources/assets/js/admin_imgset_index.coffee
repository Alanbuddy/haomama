$ ->
	$("#edit-btn").click ->
		$(this).toggle()
		$("#finish-btn").toggle()

	$("#tab2-edit-btn").click ->
		$(this).toggle()
		$("#tab2-finish-btn").toggle()
		$(".unedit-box").toggle()
		$(".edit-box").toggle()

	$("#announce").click ->
		$("#edit-btn").show()
		$("#tab2-edit-btn").hide()
		$("#tab2-finish-btn").hide()
	$("#course").click ->
		$("#tab2-edit-btn").show()
		$("#edit-btn").hide()
		$("#finish-btn").hide()

	$("#edit-btn").click ->
		$(this).toggle()
		$("#finish-btn").toggle()
		$(".unedit-box").toggle()
		$(".edit-box").toggle()

	$(".delete").click ->
		$(this).closest(".item").remove()
