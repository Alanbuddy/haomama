$ ->
  E = window.wangEditor
  editor = new E('#edit-area')
  # 图片上传地址
  editor.customConfig.uploadImgServer = '/upload' 
  editor.customConfig.showLinkImg = false
  editor.customConfig.menus = [
        'head',
        'image'
     ]
  editor.customConfig.uploadHeaders = {
    'Accept' : 'HTML'
  }
  editor.create()


  $("#edit-btn").click ->
    $(this).toggle()
    $("#finish-btn").toggle()
    $(".unedit-box").toggle()
    $(".edit-box").toggle()
    $("#second-row").removeClass("mt30")
    $(".text-message").removeClass("mt15")
    $("#reward-label").removeClass("vt")
    $("#book-label").removeClass("vt")

    $("#teacher-name").val($("#name-span").text())
    $("#mobile").val($("#mobile-span").text())
    $("#tencent").val($("#tencent-span").text())
    $("#mail").val($("#mail-span").text())
    $("#title").val($("#title-span").text())
    $("#tel").val($("#tel-span").text())
    $("#major").val($("#major-span").text())
    $("#remark").val($("#remark-span").text())
    $("#reward").val($("#reward-span").text())
    $("#book").val($("#book-span").text())
    $("#base").val($("#base-span").text())
    desc = $("#desc-span").text()
    editor.txt.html(desc)

  $("#finish-btn").click ->
    name = $("#teacher-name").val().trim
    mobile = $("#mobile").val().trim
    tencent = $("#tencent").val().trim
    mail = $("#mail").val().trim
    title = $("#title").val().trim
    tel = $("#tel").val().trim
    major = $("#major").val().trim
    remark = $("#remark").val().trim
    reward = $("#reward").val().trim
    book = $("#book").val().trim
    base = $("#base").val().trim
    desc = editor.txt.html() 






